<?php

namespace System;

final class NBoolean
    extends NObject
    implements IComparable, IConvertible
{
    private static $falseString = "false";
    private static $trueString = "true";

    private static $falseNString;
    private static $trueNString;

    public static function getFalseString()
    {
        if (self::$falseNString == null)
            self::$falseNString = NString::get(self::$falseString);

        return self::$falseNString;
    }

    public static function getTrueString()
    {
        if (self::$trueNString == null)
            self::$trueNString = NString::get(self::$trueString);

        return self::$trueNString;
    }

    private $value = false;

    // These are the cached true and false instances.
    private static $true;
    private static $false;

    private function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Returns a new instance of NBoolean for a given boolean.
     * If an NBoolean is passed in, it is returned untouched.
     *
     * @param bool|NBoolean $value
     * @return NBoolean
     */
    public static function get($value)
    {
        if ($value instanceof self)
            return $value;

        if (!is_bool($value))
            throw new ArgumentException('$value must be a bool', '$value');

        if ($value)
        {
            if (!isset(self::$true))
                self::$true = new NBoolean(true);

            return self::$true;
        }
        else
        {
            if (!isset(self::$false))
                self::$false = new NBoolean(false);

            return self::$false;
        }
    }

    /**
     * Compares this instance to a specified object and returns an integer
     * that indicates their relationship to one another.
     *
     * This method returns less than 0 when the instance is false and the
     * $object is true.
     *
     * This method returns 0 when the instance and $object are equal.
     *
     * This method returns greater than 0 when the instance is true and
     * $object is false, or if $object is null.
     *
     * @param bool|NBoolean $value
     * @return NNumber
     */
    public function compareTo($value)
    {                
        if ($value === null)
            return NNumber::get(1);

        if (!is_bool($value) && !($value instanceof self))
            throw new ArgumentException('$object is not a bool or NBoolean', '$object');

        $value = self::get($value);

        $o1 = $this->value;
        $o2 = $value->bool();
            
        if ($o1 === false && $o2 === true)
            return NNumber::get(-1);

        if ($o1 === true && $o2 === false)
            return NNumber::get(1);

        return NNumber::get(0);
    }

    /**
     * Returns a value indicating whether this instance is equal to a 
     * specified object.
     *
     * @param mixed $object An object to compare to this instance.
     * @return NBoolean True if obj is a Boolean and has the same value as
     * this instance; otherwise, false.
     */
    public function equals($object)
    {
        return self::get(
                (is_bool($object) || ($object instanceof NBoolean))
                && $this->value === self::get($object)->bool());
    }

    /**
     * Returns the hash code for this instance.
     *
     * The NBoolean class implements true as the integer, 1, and false as
     * the integer, 0. However, a particular programming language might
     * represent true and false with other values.
     *
     * @return NNumber
     */
    public function getHashCode()
    {
        return $this->value ? NNumber::get(1) : NNumber::get(0);
    }    

    /**
     * Converts the specified string representation of a logical value to
     * its NBoolean equivalent.
     *
     * The value parameter, optionally preceded or trailed by white space,
     * must contain either getTrueString() or getFalseString(); otherwise, an exception
     * is thrown. The comparison is case-insensitive.
     *
     * @param string|NString $value A string containing the value to convert.
     * @return NBoolean True if value is equivalent to getTrueString(); otherwise, false.
     *
     * @throws ArgumentNullException
     * @throws FormatException
     */
    public static function parse($value)
    {
        if ($value == null)
            throw new ArgumentNullException(null, '$value');
        
        $value = NString::get($value);        
        $str = $value->trim()->toLower()->string();

        if ($str === self::$trueString)
            return self::$true;

        if ($str === self::$falseString)
            return self::$false;

        throw new FormatException();
    }    

    /**
     * Converts the specified string representation of a logical value to its
     * NBoolean equivalent. A return value indicates whether the conversion 
     * succeeded or failed.
     * 
     * The TryParse method is like the Parse method, except the TryParse method 
     * does not throw an exception if the conversion fails.
     * 
     * The value parameter can be preceded or followed by white space. 
     * The comparison is case-insensitive.
     *
     * @param string|NString $value A string containing the value to convert.
     * @param mixed $result When this method returns, if the conversion
     * succeeded, contains true if value is equivalent to TrueString or false
     * if value is equivalent to FalseString. If the conversion failed,
     * contains false. The conversion fails if $value is null or is not
     * equivalent to either getTrueString() or getFalseString().
     * This parameter is passed uninitialized.
     * @return NBoolean True if value was converted successfully; otherwise, false.
     */
    public static function tryParse($value, &$result)
    {
        $successful = self::$false;
        
        try
        {
            $value = NString::get($value);
            $result = self::parse($value);
            $successful = self::$true;
        }
        catch (NException $e)
        {
            $result = self::$false;
        }

        return $successful;
    }

    /**
     * Returns the conjunction of <code>this && value</code>.
     *
     * @param boolean|NBoolean $value
     * @return NBoolean
     */
    public function andAlso($value)
    {
        return self::get($this->value && self::get($value)->bool());
    }

    /**
     * Returns the disjunction of <code>this || value</code>.
     *
     * @param boolean|NBoolean $value
     * @return NBoolean
     */
    public function orElse($value)
    {
        return self::get($this->value || self::get($value)->bool());
    }

    /**
     * Returns the underlying bool value.
     *
     * @return bool
     */
    public function bool()
    {
        return $this->value;
    }

    /**
     * Returns 1 if this instance is true, or 0 if it is false.
     *
     * @return int
     */
    public function int()
    {
        return $this->value ? 1 : 0;
    }

    /**
     * Returns 1.0 if this instance is true, or 0.0 if it is false.
     *
     * @return float
     */
    public function float()
    {
        return (float) $this->value ? 1 : 0;
    }

    /**
     * Converts the value of this instance to its equivalent string
     * representation (either "True" or "False").
     *
     * @return string
     */
    public function string()
    {
        return $this->value ? "True" : "False";
    }

    /**
     * Returns this instance.
     *
     * @return NBoolean
     */
    public function toBoolean()
    {
        return $this->value;
    }

    /**
     * Converts the value of this instance to its equivalent number
     * representation (either 1 for true or 0 for false).
     *
     * @return NNumber
     */
    public function toNumber()
    {
        return NNumber::get($this->int());
    }

    /**
     * Converts the value of this instance to its equivalent NString
     * representation (either "True" or "False").
     *
     * @return NString
     */
    public function toString()
    {
        return NString::get($this->string());
    }

}
