<?php

namespace System;

final class NInteger
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

    public function __construct($value = 0)
    {
        $this->value = (int) $value;
    }

    public function compareTo(IObject $integer)
    {

    }  
    
    public function boolValue()
    {
        return (bool) $this->value;
    }

    public function intValue()
    {
        return $this->value;
    }

    public function floatValue()
    {
        return (float) $this->value;
    }

    public function stringValue()
    {
        return (string) $this->value;
    }

}
