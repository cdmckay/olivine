<?php

namespace System;

class NException extends \Exception implements IObject
{    
    public function __construct($message = null, $errorCode = 0, NException $innerException = null)
    {
        parent::__construct(null, 0, $innerException);

        // Overwrite message with an NString.
        if ($message !== null)
            $this->message = NString::get($message);

        $this->code = NInt::get($errorCode);
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

    public function __call($name, $arguments)
    {
        return NObject::methodDispatcher($this, $name, $arguments);
    }

    public static function addMethod($methodName, $method)
    {
        NObject::addMethod($methodName, $method, get_called_class());
    }
}
