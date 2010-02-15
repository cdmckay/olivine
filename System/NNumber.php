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
    private $value = '0';   

    private function __construct($value)
    {
        $this->value = $value;
    }

    public static function get($value)
    {       
        $val = "0";

        if ((is_int($value) || is_float($value) || is_string($value))
                && preg_match(self::$numberPattern, (string) $value, $matches) !== 0)
        {            
            if (count($matches) > 2)
            {                
                $number = $matches[1];
                $exponent = $matches[3];
                $val = bcmul($number, bcpow(10, $exponent));
            }
            else
            {
                $val = trim($value);
            }
        }
        else
        {
            throw new ArgumentException("Argument must be an int, float or a string containing a number: $value", '$value');
        }

        return new NNumber($val);
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
            return new NNumber(1);

        if (!($object instanceof NNumber))
            throw new ArgumentException('$object is not an NNumber', '$object');

        $o1 = $this->intValue();
        $o2 = $object->intValue();
             
        if ($o1 < $o2) return new NNumber(-1);
        if ($o1 > $o2) return new NNumber(1);

        return new NNumber(0);
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
                && $this->intValue() === $object->intValue());
    }

    public function parse(NString $value)
    {

    }

    public function tryParse(NString $value, NBoolean &$result = null)
    {
        
    }

    public function negate()
    {
        return self::get(bcmul($this->value, '-1'));
    }

    public function plus(NNumber $value)
    {        
        return self::get(bcadd($this->value, $value->stringValue()));
    }

    public function minus(NNumber $value)
    {        
        return self::get(bcsub($this->value, $value->stringValue()));
    }

    public function times(NNumber $value)
    {        
        return self::get(bcmul($this->value, $value->stringValue()));
    }

    public function divide(NNumber $value)
    {       
        return self::get(bcdiv($this->value, $value->stringValue()));
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
        $val = Math::ceiling($this)->stringValue();
        $ret = (int) $val;

        if (strcmp(((string) $ret), $val) !== 0)
            throw new OverflowException("An int is not wide enough to hold: $val");

        return $ret;
    }

    public function floatValue()
    {
        $val = $this->value;
        $ret = (float) $val;        

        if (is_infinite($ret) || ($ret === 0.0 && !preg_match("#^0(\.0+)?$#", $val)))
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
