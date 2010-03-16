<?php

namespace System;

final class NString
    extends NObject
    implements IComparable, ICloneable, IConvertible, IEnumerable
{
    const EMPTY_STRING = "";

    private $value = null;

    private function __construct($value)
    {        
        $this->value = $value;
    }

    public static function get($value)
    {
        if (!is_string($value))
            throw new ArgumentException('$value must be a string', '$value');

        return new NString($value);
    }

    public function __clone()
    {
        
    }

    public function compareTo(IObject $object = null)
    {
        
    }

    public function toLower()
    {
        return new NString(strtolower($this->value));
    }

    public function toString()
    {
        return $this;
    }

    public function toUpper()
    {
        return new NString(strtoupper($this->value));
    }

    public function trim()
    {
        return new NString(trim($this->value));
    }

    public function trimStart()
    {
        return new NString(ltrim($this->value));
    }

    public function trimEnd()
    {
        return new NString(rtrim($this->value));
    }

    public function boolValue()
    {
        return (bool) $this->value;
    }

    public function intValue()
    {
        return (int) $this->value;
    }

    public function floatValue()
    {
        return (float) $this->value;
    }

    public function stringValue()
    {
        return $this->value;
    }

    public function toBoolean()
    {

    }

    public function toNumber()
    {
        
    }

    // PHP-specific

    public function capitalizeFirst()
    {

    }

    public function capitalize()
    {
        
    }

    public function wrap()
    {

    }

}
