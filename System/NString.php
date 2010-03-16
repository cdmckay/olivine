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

    public static function compare(NString $strA, NString $strB, NBoolean $ignoreCase = null)
    {
        if ($ignoreCase === null) $ignoreCase = NBoolean::get(false);
    }

    public static function compareOrdinal(NString $strA, NString $strB)
    {

    }

    public function concat(IObject $arg0, IObject $arg1 = null, IObject $arg2 = null, IObject $arg3 = null)
    {
        $str = $arg0->toString()->stringValue();
        if ($arg1 !== null) $str += $arg1;
        if ($arg2 !== null) $str += $arg2;
        if ($arg3 !== null) $str += $arg3;
        return self::get($str);
    }

    public static function staticConcat(IObject $arg0, IObject $arg1 = null, IObject $arg2 = null, IObject $arg3 = null)
    {
        return $arg0->toString()->concat($arg1, $arg2, $arg3);
    }   

    public function compareTo(IObject $object = null)
    {
        
    }

    public function contains(NString $value)
    {

    }

    public static function copy(NString $str)
    {
        return self::get($str->stringValue());
    }

    public function endsWith(NString $value, NBoolean $ignoreCase = null)
    {
        if ($ignoreCase === null) $ignoreCase = NBoolean::get(false);
    }

    public function equals(IObject $object = null)
    {
        
    }

    public static function staticEquals(IObject $object1 = null, IObject $object2 = null)
    {
        
    }

    public static function format(NString $format /*, $arg0, $arg1, ... */)
    {
        $args = func_get_args();
        $args_slice = array_slice($args, 1);
        $fixed_args = array();
        foreach ($args_slice as $arg)
        {
            if (!($arg instanceof IObject))
                throw new ArgumentException("Argument must be an IObject");

            if (false);
            else if ($arg instanceof NString)
            {
                $fixed_args[] = $arg->stringValue();
            }
            else if ($arg instanceof NNumber)
            {
                $fixed_args[] = $arg->floatValue();
            }
            else
            {
                $fixed_args[] = $arg->toString()->stringValue();
            }
        }
        return self::get(vsprintf($format->stringValue(), $fixed_args));
    }

    public function toLower()
    {
        return self::get(strtolower($this->value));
    }    

    public function toUpper()
    {
        return self::get(strtoupper($this->value));
    }

    public function trim()
    {
        return self::get(trim($this->value));
    }

    public function trimStart()
    {
        return self::get(ltrim($this->value));
    }

    public function trimEnd()
    {
        return self::get(rtrim($this->value));
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

    public function toString()
    {
        return $this;
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
