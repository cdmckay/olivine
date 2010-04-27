<?php

/*
 * (c) Copyright 2010 Cameron McKay
 *
 * This file is part of Olivine.
 *
 * Olivine is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Olivine is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with Olivine.  If not, see <http://www.gnu.org/licenses/>.
 */

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
        return NBool::get($this === $object);
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
