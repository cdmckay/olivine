<?php

namespace System;

class NBoolean
    extends NObject
    implements IComparable, IConvertible //, IFormattable, IEquatable
{
    const FALSE_STRING = "false";
    const TRUE_STRING = "true";

    private $value = false;

    public function NBoolean($value)
    {
        $this->value = (bool) $value;
    }

    /**
     * Compares this instance to a specified object and returns an integer
     * that indicates their relationship to one another.
     *
     * This method returns less than 0 when the instance is false and the
     * $object is true.
     *
     * This method returns 0 when the instance and $object are equal.
     *
     * This method returns greather than 0 when the instance is true and
     * $object is false, or if $object is null.
     *
     * @param NObject $object
     * @return NInteger
     */
    public function compareTo(NObject $object)
    {
        // TODO We need an ArgumentException.
        if (!($object instanceof NBoolean))
            throw new Exception('$object is not a NBoolean');

        if ($object === null)
            return new NInteger(1);

        $o1 = $this->toNativeBoolean();
        $o2 = $object->toNativeBoolean();

        if ($o1 === $o2)
            return new NInteger(0);

        if ($o1 === false && $o2 === true)
            return new NInteger(-1);

        if ($o1 === true && $o2 === false)
            return new NInteger(1);
    }

    public function getHashCode()
    {
        return $this->value ? new NInteger(1) : new NInteger(0);
    }

    public function toNativeArray()
    {
        throw new Exception();
    }

    public function toNativeBoolean()
    {
        return $this->value;
    }

    public function toNativeInteger()
    {
        return $this->value ? 1 : 0;
    }

    public function toNativeString()
    {
        return (string) $this->value;
    }

}
