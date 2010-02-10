<?php

namespace System;

interface IObject
{
    public static function staticEquals(IObject $object1, IObject $object2);
    public static function referenceEquals(IObject $object1, IObject $object2);
    public function equals(IObject $object);
    public function getHashCode();
    public function getType();
    public function memberwiseClone();
    public function toString();    
}
