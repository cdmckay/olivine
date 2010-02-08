<?php

// TODO all strings returned by an NObject should be NString.

namespace System;

class NObject
{
    public static function staticEquals($object1, $object2)
    {
        return $object1->equals($object2);
    }

    public static function referenceEquals($object1, $object2)
    {
        return $object1 === $object2;
    }

    public function equals($object)
    {
        return $this === $object;
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


