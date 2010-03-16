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

    /**
     * Returns an NNumber instance for a given int, float or string
     * containing a number.
     * 
     * The number string may have an exponent, i.e. "2.0e2".
     *
     * @param mixed $value An int, float or string containing a number.
     * @return NNumber
     */
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

    /**
     * Converts the string representation of a number to its NNumber equivalent.
     *
     * The <code>$value</code> parameter contains a number of the form:
     * [ws][sign]integral-digits[.[fractional-digits]][e[sign]exponential-digits][ws]
     *
     * where:
     * 
     * ws is a series of white space characters.
     * sign is a negative sign or positive sign symbol. Only a leading sign can be used.
     * integral-digits is a series of digits ranging from 0 to 9 that specify the integral part of the number.
     * fractional-digits is a series of digits ranging from 0 to 9 that specify the fractional part of the number.
     * e is an uppercase or lowercase character 'e', indicating exponential (scientific) notation.
     * exponential-digits is a series of digits ranging from 0 to 9 that specify an exponent.
     *
     * For example: <code>-10.12345e+10</code>
     *
     * @param NString $value A string containing a number to convert. 
     * @return NNumber
     *
     * @throws ArgumentNullException if $value is null
     * @throws FormatException if $value is not the correct format
     */
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

    /**
     * Converts the string representation of a number to its NNumber equivalent.
     * A return value indicates whether the conversion succeeded or failed.
     *
     * The <code>$value</code> parameter contains a number of the form:
     * [ws][sign]integral-digits[.[fractional-digits]][e[sign]exponential-digits][ws]
     *
     * where:
     *
     * ws is a series of white space characters.
     * sign is a negative sign or positive sign symbol. Only a leading sign can be used.
     * integral-digits is a series of digits ranging from 0 to 9 that specify the integral part of the number.
     * fractional-digits is a series of digits ranging from 0 to 9 that specify the fractional part of the number.
     * e is an uppercase or lowercase character 'e', indicating exponential (scientific) notation.
     * exponential-digits is a series of digits ranging from 0 to 9 that specify an exponent.
     *
     * @param NString $value A string containing a number to convert. 
     * @param NNumber $result When this method returns, contains the
     * NNumber equivalent to the $value parameter, if the conversion succeeded,
     * or zero if the conversion failed. The conversion fails if the $value
     * parameter is null, is not a number in a valid format, This parameter
     * is passed uninitialized.
     * @return NBoolean
     */
    public static function tryParse(NString $value = null, NNumber &$result = null)
    {
        $successful = NBoolean::get(false);

        try
        {
            $result = self::parse($value);
            $successful = NBoolean::get(true);
        }
        catch (NException $e)
        {
            $result = NNumber::get(0);
        }

        return $successful;
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

     /**
     * Converts the NNumber to a boolean
     *
     * @return boolean True if the value of the current instance is zero;
     * otherwise false.
     */
    public function boolValue()
    {
        return $this->equals(self::get(0));
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
        return NBoolean::get($this->boolValue());
    }

    public function toNumber()
    {
        return $this;
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
        return NString::get($this->stringValue());
    }

    /**
     * Checks that a PHP string has a particular number format
     * expected by NNumber.
     *
     * @param string $str
     * @return string
     */
    private static function hasNumberFormat($str)
    {
        return preg_match(self::$numberPattern, $str) === 1;
    }

    /**
     * Expands the exponent in a PHP string if the string has one.
     *
     * For example, "2e2" would become "200".
     *
     * If the string does not have an exponent it will be returned unchanged.
     *
     * @param string $str
     * @return string
     */
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

}
