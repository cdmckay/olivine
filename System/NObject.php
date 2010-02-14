<?php

namespace System;

class NObject
    implements IObject
{
    public static function staticEquals(IObject $object1 = null, IObject $object2 = null)
    {
        return $object1->equals($object2);
    }

    public static function referenceEquals(IObject $object1 = null, IObject $object2 = null)
    {
        return NBoolean::get($object1 === $object2);
    }

    public function equals(IObject $object = null)
    {
        return NBoolean::get($this === $object);
    }

    /**
     *
     * @return NString
     */
    public function getHashCode()
    {
        return new NString(spl_object_hash($this));
    }

    /**
     * Gets the Type of the current instance as an NString.
     *
     * @return NString
     */
    public function getType()
    {
        return new NString(get_class($this));
    }

    public function memberwiseClone()
    {
        // TODO This should be replaced with a custom memberwise
        // clone that will always do a shallow copy.  Right now it'll
        // call the __clone() method if it exists.
        return clone $this;
    }

    /**
     * Returns an NString that represents the current NObject.
     *
     * @return NString
     */
    public function toString()
    {
        return new NString(get_class($this));
    }

    /**
     * Returns a PHP string that represents the current NObject.
     *
     * @return string
     */
    public function __toString()
    {
        // This wraps the magic __toString to our toString method.
        return $this->toString()->stringValue();
    }

}


