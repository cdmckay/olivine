<?php

namespace System;

interface IObject
{
    public static function staticEquals(IObject $object1 = null, IObject $object2 = null);
    public static function referenceEquals(IObject $object1 = null, IObject $object2 = null);
    public function equals(IObject $object = null);
    public function getHashCode();
    public function getType();
    public function memberwiseClone();
    public function toString();    
}
