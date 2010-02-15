<?php

// Ideally, in the future, I'd like the NNumber class to automatically
// switch between fixed and arbitrary precision types for performance.
// For example, if the value being wrapped is int or float, it'll automatically
// use those values internally for arithmetic.

namespace System;

final class NNumber
    extends NObject
    implements IComparable, IConvertible /* IFormattable */
{
    private static $numberPattern 
        = "#^([-+]?[0-9]*\.?[0-9]+)([eE]([-+]?[0-9]+))?$#";
    private static $scale = 10;
    private $value;   

    private function __construct($value)
    {
        $this->value = $value;
    }

    public static function get($value)
    {
        $str = null;

        if (is_int($value) || is_float($value))
        {
            $str = (string) $value;
        }

        if (is_string($value))
        {
            $val = trim($value);
            if (self::hasNumberFormat($val))
            {
                $str = $val;
            }
        }

        if ($str === null)
        {
            $message = "Argument must be an int, float or a string containing a number: $value";
            throw new ArgumentException($message, '$value');
        }

        return new NNumber(self::expandExponent($str));
    }

    /**
     * Compares this instance to a specified object and returns an indication
     * of their relative values.
     *
     * This method returns less than 0 if this instance is less than $object.
     * 
     * This method returns 0 if this instance is equal to $object.
     * 
     * This method returns greater than 0 if this instance is greater than
     * $object, or $object is null.
     *
     * @param IObject $object
     * @return NNumber A signed number indicating the relative values of
     * this instance and value.
     */
    public function compareTo(IObject $object = null)
    {
        if ($object === null)
            return self::get(1);

        if (!($object instanceof NNumber))
            throw new ArgumentException('$object is not an NNumber', '$object');

        $o1 = $this->stringValue();
        $o2 = $object->stringValue();

        return self::get(bccomp($o1, $o2, self::$scale));
    }

    /**
     * Returns a value indicating whether this instance is equal to a
     * specified object.
     *
     * @param IObject $object An object to compare with this instance.
     * @return NBoolean True if obj is an instance of NNumber and equals
     * the value of this instance; otherwise, false.
     */
    public function equals(IObject $object = null)
    {
        return NBoolean::get($object instanceof NNumber
                && bccomp($this->value, $object->stringValue(), self::$scale) === 0);
    }

    private static function hasNumberFormat($str)
    {
        return preg_match(self::$numberPattern, $str) === 1;
    }

    private static function expandExponent($str)
    {
        $ret = $str;
        if (preg_match(self::$numberPattern, $str, $matches) !== 0)
        {
            if (count($matches) > 2)
            {
                $number = $matches[1];
                $exponent = $matches[3];
                $ret = bcmul($number, bcpow(10, $exponent), self::$scale);
            }
        }

        return $ret;
    }

    public static function parse(NString $value = null)
    {
        if ($value == null)
        {
            throw new ArgumentNullException(null, '$value');
        }

        $str = $value->trim()->stringValue();

        if (!self::hasNumberFormat($str))
        {
            throw new FormatException();
        }

        return self::get($str);
    }

    public static function tryParse(NString $value = null, NBoolean &$result = null)
    {
        
    }

    public function negate()
    {
        return self::get(bcmul($this->value, '-1', self::$scale));
    }

    public function plus(NNumber $value)
    {        
        return self::get(bcadd($this->value, $value->stringValue(), self::$scale));
    }

    public function minus(NNumber $value)
    {        
        return self::get(bcsub($this->value, $value->stringValue(), self::$scale));
    }

    public function times(NNumber $value)
    {        
        return self::get(bcmul($this->value, $value->stringValue(), self::$scale));
    }

    public function divide(NNumber $value)
    {       
        return self::get(bcdiv($this->value, $value->stringValue(), self::$scale));
    }

    public function modulus(NNumber $value)
    {        
        return self::get(bcmod($this->value, $value->stringValue()));
    }
       
    public function boolValue()
    {
        return (bool) $this->value;
    }

    public function intValue()
    {
        $val = Math::floor($this)->stringValue();
        $ret = (int) $val;

        if (strcmp(((string) $ret), $val) !== 0)
            throw new OverflowException("An int is not wide enough to hold: $val");

        return $ret;
    }

    public function floatValue()
    {
        $val = $this->value;
        $ret = (float) $val;        

        if (is_infinite($ret))
            throw new OverflowException("A float is not wide enough to hold: $val");

        return $ret;
    }

    public function stringValue()
    {
        return $this->value;
    }

    public function toBoolean()
    {

    }

    public function toInteger()
    {

    }

    public function toFloat()
    {

    }

    /**
     * Converts the numeric value of this instance to its equivalent 
     * string representation.
     *
     * @return NString The string representation of the value of this instance,
     * consisting of a negative sign if the value is negative, and a sequence
     * of digits ranging from 0 to 9 with no leading zeroes.
     */
    public function toString()
    {
        return new NString($this->stringValue());
    }

}
