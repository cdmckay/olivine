<?php

namespace System;

class NInteger 
    extends NObject
    implements IComparable, IConvertible //, IFormattable, IEquatable
{

    public static function getMaxValue()
    {
        return PHP_INT_MAX;
    }

    public static function getMinValue()
    {
        return -PHP_INT_MAX - 1;
    }

    private $value = 0;

    public function NInteger($value = 0)
    {
        $this->value = (int) $value;
    }

    public function compareTo(NObject $integer)
    {

    }

    public function toNativeArray()
    {
        throw new Exception();
    }
    
    public function toNativeBoolean()
    {
        return (bool) $this->value;
    }

    public function toNativeInteger()
    {
        return $this->value;
    }

    public function toNativeString()
    {
        return (string) $this->value;
    }

}
