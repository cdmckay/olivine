<?php

namespace System;

final class NBoolean
    extends NObject
    implements IComparable, IConvertible //, IFormattable, IEquatable
{
    const FALSE_STRING = "false";
    const TRUE_STRING = "true";

    private $value = false;

    private static $true;
    private static $false;

    private function __construct($value)
    {
        $this->value = $value;
    }

    public static function get($value)
    {
        if (!is_bool($value))
            throw new ArgumentException('$value must be a bool', '$value');

        if ($value)
        {
            if (!isset(NBoolean::$true))
                NBoolean::$true = new NBoolean(true);

            return NBoolean::$true;
        }
        else
        {
            if (!isset(NBoolean::$false))
                NBoolean::$false = new NBoolean(false);

            return NBoolean::$false;
        }
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
    public function compareTo(IObject $object)
    {
        // TODO We need an ArgumentException.
        if (!($object instanceof NBoolean))
            throw new ArgumentException('$object is not an NBoolean', '$object');

        if ($object === null)
            return new NInteger(1);

        $o1 = $this->boolValue();
        $o2 = $object->boolValue();

        if ($o1 === $o2)
            return new NInteger(0);

        if ($o1 === false && $o2 === true)
            return new NInteger(-1);

        if ($o1 === true && $o2 === false)
            return new NInteger(1);
    }

    /**
     *
     * @param IObject $object
     * @return NBoolean
     */
    public function equals(IObject $object)
    {
        return $object instanceof NBoolean
                && $this->toNativeBoolean() === $object->bool();
    }

    /**
     * Returns the hash code for this instance.
     *
     * The NBoolean class implements true as the integer, 1, and false as
     * the integer, 0. However, a particular programming language might
     * represent true and false with other values.
     *
     * @return NInteger
     */
    public function getHashCode()
    {
        return $this->value ? new NInteger(1) : new NInteger(0);
    }    

    public static function parse($value)
    {
        if ($value == null)
            throw new ArgumentNullException(null, '$value');

        if (!($value instanceof NString))
            throw new ArgumentException('$value is not an NString', '$value');

        
    }

    public function boolValue()
    {
        return $this->value;
    }

    public function intValue()
    {
        return $this->value ? 1 : 0;
    }

    public function floatValue()
    {
        return (float) $this->value ? 1 : 0;
    }

    public function stringValue()
    {
        return (string) $this->value;
    }

}
