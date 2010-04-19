<?php

namespace System;

interface IObject
{
    public static function staticEquals($object1, $object2);
    public static function referenceEquals($object1, $object2);
    public function equals($object);
    public function getHashCode();
    public function getType();
    public function memberwiseClone();
    public function toString();    
}
