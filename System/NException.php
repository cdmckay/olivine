<?php

namespace System;

class NException extends \Exception implements IObject
{    
    public function __construct($message = null, $errorCode = 0, NException $innerException = null)
    {
        parent::__construct($message, $errorCode, $innerException);              
    }

    public static function referenceEquals($object1, $object2)
    {
        NObject::referenceEquals($object1, $object2);
    }

    public static function staticEquals($object1, $object2)
    {
        NObject::staticEquals($object1, $object2);
    }

    public function getInnerException()
    {
        return $this->getPrevious();
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
        return clone $this;
    }

    public function toString()
    {
        return parent::__toString();
    }

    public function __toString()
    {
        return $this->toString();
    }

}
