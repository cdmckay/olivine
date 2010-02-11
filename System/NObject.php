<?php

// TODO all strings returned by an NObject should be NString.

namespace System;

class NObject
    implements IObject
{
    public static function staticEquals(IObject $object1, IObject $object2)
    {
        return $object1->equals($object2);
    }

    public static function referenceEquals(IObject $object1, IObject $object2)
    {
        return NBoolean::get($object1 === $object2);
    }

    public function equals(IObject $object)
    {
        return NBoolean::get($this === $object);
    }

    public function getHashCode()
    {
        return spl_object_hash($this);
    }

    public function getType()
    {
        return get_class($this);
    }

    public function memberwiseClone()
    {
        // TODO This should be replaced with a custom memberwise
        // clone that will always do a shallow copy.  Right now it'll
        // call the __clone() method if it exists.
        return clone $this;
    }

    public function toString()
    {
        return get_class($this);
    }

    public function __toString()
    {
        // This wraps the magic __toString to our toString method.
        return $this->toString();
    }

}


