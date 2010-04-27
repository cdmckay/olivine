<?php

/*
 * (c) Copyright 2010 Cameron McKay
 *
 * This file is part of Olivine.
 *
 * Olivine is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Olivine is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with Olivine.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace System;

final class NInt
    extends NObject
    implements INumber, IComparable, IConvertible /* IFormattable */
{    
    private $value;

    private function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Returns an NInt instance for a given int or NInt.
     *
     * @param int|NInt $value An int or NInt.
     * @return NInt
     */
    public static function get($value)
    {
        if ($value instanceof self)
            return $value;

        if (!is_int($value))
            throw new ArgumentException('$value must be an int or an NInt', '$value');
       
        return new NInt($value);
    }

    public static function primitive($value)
    {
        if (is_int($value))
            return $value;

        if ($value instanceof self)
            return $value->int();

        throw new ArgumentException('$value must be an int or an NInt', '$value');
    }        

    /**
     * Compares this instance to a specified object and returns an indication
     * of their relative values.
     *
     * This method returns less than 0 if this instance is less than $value.
     *
     * This method returns 0 if this instance is equal to $value.
     *
     * This method returns greater than 0 if this instance is greater than
     * $object, or $value is null.
     *
     * @param int|NInt $value
     * @return NInt A signed number indicating the relative values of
     * this instance and value.
     */
    public function compareTo($value)
    {
        if ($value === null)
            return self::get(1);

        $o1 = $this->value;
        $o2 = self::primitive($value);

        if ($o1 === $o2) return self::get(0);
        return self::get($o1 > $o2 ? 1 : -1);
    }

    /**
     * Returns a value indicating whether this instance is equal to a
     * specified object.
     *
     * @param mixed $object An object to compare with this instance.
     * @return NBool True if $object is an instance of NInt and equals
     * the value of this instance; otherwise, false.
     */
    public function equals($object)
    {
        return NBool::get(
                (is_int($object) || $object instanceof NInt)
                && $this->value === self::primitive($object));
    }

    /**
     * Converts the string representation of a number to its NInt equivalent.
     *
     * The <code>$value</code> parameter contains a number of the form:
     * [ws][sign]digits[ws]
     *
     * where:
     *
     * ws is a series of white space characters.
     * sign is a negative sign or positive sign symbol. Only a leading sign can be used.
     * digits is a sequence of digits ranging from 0 to 9.
     *
     * For example: <code>-42</code>
     *
     * @param string|NString $value A string containing a number to convert.
     * @return NInt
     *
     * @throws ArgumentNullException if $value is null
     * @throws FormatException if $value is not the correct format
     * @throws OverflowException
     */
    public static function parse($value)
    {
        if ($value === null)
            throw new ArgumentNullException(null, '$value');        

        $pattern = "#^([-+]?[0-9]+)$#";
        $value = trim(NString::primitive($value));

        if (!(preg_match($pattern, $value) === 1))
            throw new FormatException();

        if (bccomp($value, (string) PHP_INT_MAX) === 1
                || bccomp($value, (string) -PHP_INT_MAX - 1) === -1)
            throw new OverflowException("Value in string is too wide for an NInt: " . $value);

        return self::get((int) $value);
    }

    /**
     * Converts the string representation of a number to its NInt equivalent.
     * A return value indicates whether the conversion succeeded or failed.
     *
     * The <code>$value</code> parameter contains a number of the form:
     * [ws][sign]digits[ws]
     *
     * where:
     *
     * ws is a series of white space characters.
     * sign is a negative sign or positive sign symbol. Only a leading sign can be used.
     * digits is a sequence of digits ranging from 0 to 9.
     *
     * @param string|NString $value A string containing a number to convert.
     * @param mixed $result When this method returns, contains the
     * NInt equivalent to the $value parameter, if the conversion succeeded,
     * or zero if the conversion failed. The conversion fails if the $value
     * parameter is null, is not a number in a valid format, This parameter
     * is passed uninitialized.
     * @return NBool
     */
    public static function tryParse($value, &$result)
    {
        $successful = false;

        try
        {
            $value = NString::get($value);
            $result = self::parse($value);
            $successful = true;
        }
        catch (NException $e)
        {
            $result = NInt::get(0);
        }

        return NBool::get($successful);
    }

    /**
     * Returns a number that is negation of <code>this</code>.
     *
     * @return NInt
     */
    public function negate()
    {
        return self::get(-$this->value);
    }

    /**
     * Returns a number that is the sum of <code>this + value</code>.
     *
     * @param int|NInt $value The value to be added.
     * @return NInt The sum.
     *
     * @throws ArgumentNullException if $value is null
     */
    public function plus($value)
    {
        if ($value === null)        
            throw new ArgumentNullException(null, '$value');

        $result = $this->value + self::primitive($value);

        if (is_float($result))
            throw new OverflowException();

        return self::get($result);
    }

    /**
     * Returns a number that is the difference of <code>this - value</code>.
     *
     * @param int|NInt $value The value to be subtracted.
     * @return NInt The difference.
     *
     * @throws ArgumentNullException if $value is null
     */
    public function minus($value)
    {
        if ($value === null)        
            throw new ArgumentNullException(null, '$value');        

        $result = $this->value - self::primitive($value);

        if (is_float($result))
            throw new OverflowException();

        return self::get($result);
    }

    /**
     * Returns a number that is the product of <code>this * value</code>.
     *
     * @param int|NInt $value The value to be multiplied.
     * @return NInt The product.
     *
     * @throws ArgumentNullException if $value is null
     */
    public function times($value)
    {
        if ($value === null)        
            throw new ArgumentNullException(null, '$value');        

        $result = $this->value * self::primitive($value);

        if (is_float($result))
            throw new OverflowException();

        return self::get($result);
    }

    /**
     * Returns a number that is the quotient of <code>this / value</code>.
     *
     * @param int|NInt $value The value to be divided.
     * @return NInt The quotient.
     *
     * @throws ArgumentNullException if $value is null
     */
    public function divide($value)
    {
        if ($value === null)        
            throw new ArgumentNullException(null, '$value');
        
        $result = $this->value / self::primitive($value);

        if (is_float($result))
            throw new OverflowException();

        return self::get($result);
    }

    /**
     * Returns a number that is the result of <code>this % value</code>.
     *
     * @param int|NInt $value
     * @return NInt
     *
     * @throws ArgumentNullException if $value is null
     */
    public function modulus($value)
    {
        if ($value === null)       
            throw new ArgumentNullException(null, '$value');        

        $result = $this->value % self::primitive($value);

        if (is_float($result))
            throw new OverflowException();

        return self::get($result);
    }

    /**
     * Returns a NBool that is the result of <code>this < value</code>.
     *
     * @param int|NInt $value
     * @return NBool
     *
     * @throws ArgumentNullException if $value is null
     */
    public function isLessThan($value)
    {
        if ($value === null)
        {
            throw new ArgumentNullException(null, '$value');
        }

        return NBool::get($this->value < self::primitive($value));
    }

    /**
     * Returns a NBool that is the result of <code>this <= value</code>.
     *
     * @param int|NInt $value
     * @return NBool
     *
     * @throws ArgumentNullException if $value is null
     */
    public function isLessThanOrEqualTo($value)
    {
        if ($value === null)
        {
            throw new ArgumentNullException(null, '$value');
        }

        return NBool::get($this->value <= self::primitive($value));
    }

    /**
     * Returns a NBool that is the result of <code>this > value</code>.
     *
     * @param int|NInt $value
     * @return NBool
     *
     * @throws ArgumentNullException if $value is null
     */
    public function isGreaterThan($value)
    {
        if ($value === null)
            throw new ArgumentNullException(null, '$value');        

        return NBool::get($this->value > self::primitive($value));
    }

    /**
     * Returns a NBool that is the result of <code>this >= value</code>.
     *
     * @param int|NInt $value
     * @return NBool
     *
     * @throws ArgumentNullException if $value is null
     */
    public function isGreaterThanOrEqualTo($value)
    {
        if ($value === null)        
            throw new ArgumentNullException(null, '$value');
        
        return NBool::get($this->value >= self::primitive($value));
    }

    /**
     * Converts this NInt to a boolean primitive.
     *
     * @return boolean True if the value of the current instance is zero;
     * otherwise false.
     */
    public function bool()
    {
        return $this->value === 0;
    }

    /**
     * Returns the int value of this NInt, if it is small enough.
     *
     * @return int
     */
    public function int()
    {
        return $this->value;
    }

    /**
     * Returns the float value of this NInt.
     *
     * @return float
     */
    public function float()
    {        
        return (float) $this->value;
    }

    /**
     * Returns the string value of this NInt.
     * For example, if the value 42 then this would return "42".
     *
     * @return string
     */
    public function string()
    {
        return (string) $this->value;
    }

    /**
     * Converts this NInt to an NBool instance.
     *
     * @return NBool True if the value of the current instance is zero;
     * otherwise false.
     */
    public function toBoolean()
    {
        return NBool::get($this->bool());
    }

    /**
     * Returns this instance untouched.
     *
     * @return NInt
     */
    public function toInteger()
    {
        return $this;
    }

    public function toFloat()
    {
        //return NFloat::get($this);
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
        return NString::get($this->string());
    }    
}
