<?php

namespace System;

final class NNumber
    extends NObject
    implements IComparable, IConvertible /* IFormattable */
{
    private static $maxInt = null;
    private static $maxFloat = null;
    private static $numberPattern = "#(\-|\+)?[0-9](\.[0-9]+)?#";
    private static $scale = 10;
    private $value = '0';

    /**
     * Gets the maximum PHP float value allowed on this machine.
     *
     * @return The maximum PHP float value.
     */
    public static function getMaxFloat()
    {
        if (self::$maxFloat === null)
        {
            $val1 = 2;
            $val2 = 2;

            while (true)
            {
                $val2 = bcmul( $val1, $val1, 0 );
                if ((string) ((float) $val2) === 'INF') break;
                $val1 = $val2;
            }

            while (true)
            {
                $val2 = bcadd( $val1, $val1, 0 );
                if ((string) ((float) $val2) === 'INF') break;
                $val1 = $val2;
            }

            $mod = bcdiv( $val1, 2, 0 );

            while (true)
            {
                if ((float) $mod < 1) break;
                $val2 = bcadd( $val1, $mod, 0 );

                if ((string) ((float) $val2) === 'INF')
                {
                    $mod = bcdiv( $mod, 2, 0 );
                }
                else
                {
                    $val1 = $val2;
                }
            }

            self::$maxFloat = NNumber::get($val1);
        }

        return self::$maxFloat;
    }

    /**
     * Gets the maximum PHP int value allowed on this machine.
     *
     * @return The maximum PHP int value.
     */
    public static function getMaxInt()
    {
        if (self::$maxInt === null)
        {
            self::$maxInt = NNumber::get(PHP_INT_MAX);
        }

        return self::$maxInt;
    }

    private function __construct($value = 0)
    {
        $this->value = $value;
    }

    public static function get($value)
    {       
        $val = "0";

        if (false) {}
        else if (is_int($value) || is_float($value))
        {
            $val = (string) $value;
        }        
        else if (is_string($value) && preg_match(self::$numberPattern, $value))
        {
            $val = $value;
        }
        else
        {
            throw new ArgumentException("Argument must be an int, float or a string containing a number: $value", '$value');
        }

        return new NNumber($value);
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
        $val = Math::ceiling($this);        

        if (bccomp($val, self::getMaxInt()->stringValue()) <= 0)
            return (int) $val;

        throw new OverflowException("An int is not large enough to hold: $val");
    }

    public function floatValue()
    {
        $val = $this->value;
        
        if (bccomp($val, self::getMaxFloat()->stringValue()) <= 0)
            return (float) $val;

        throw new OverflowException("A float is not large enough to hold: $val");
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
