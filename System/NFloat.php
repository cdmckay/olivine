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

final class NFloat
    extends NObject
    implements INumber, IComparable, IConvertible /* IFormattable */
{
    private $value;

    private function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Returns an NFloat instance for a given int, float or NFloat.
     *
     * @param int|float|NFloat $value A float or NFloat.
     * @return NFloat
     */
    public static function get($value)
    {
        if ($value instanceof self)
            return $value;

        if (!is_int($value) && !is_float($value))
            throw new ArgumentException('$value must be an int, a float or an NFloat', '$value');

        return new NFloat((float) $value);
    }

    public static function primitive($value)
    {
        if (is_int($value) || is_float($value))
            return (float) $value;

        if ($value instanceof self)
            return $value->float();

        throw new ArgumentException('$value must be an int, a float or an NFloat', '$value');
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
     * @param int|float|NFloat $value
     * @return NInt A signed number indicating the relative values of
     * this instance and value.
     */
    public function compareTo($value)
    {
        if ($value === null)
            return NInt::get(1);

        $o1 = $this->value;
        $o2 = self::primitive($value);

        if ($o1 === $o2) return self::get(0);
        return NInt::get($o1 > $o2 ? 1 : -1);
    }

    /**
     * Returns a value indicating whether this instance is equal to a
     * specified object.
     *
     * @param mixed $object An object to compare with this instance.
     * @return NBool True if $object is an instance of NFloat and equals
     * the value of this instance; otherwise, false.
     */
    public function equals($object)
    {
        return NBool::get(
                (is_int($object) || is_float($object) || $object instanceof NFloat)
                && $this->value === self::primitive($object));
    }

    /**
     * Converts the string representation of a number to its NFloat equivalent.
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
     * @param string|NString $value A string containing a number to convert.
     * @return NFloat
     *
     * @throws ArgumentNullException if $value is null
     * @throws FormatException if $value is not the correct format
     */
    public static function parse($value)
    {
        if ($value === null)
            throw new ArgumentNullException(null, '$value');

        $pattern = "#^([-+]?[0-9]*\.?[0-9]+)([eE]([-+]?[0-9]+))?$#";
        $value = trim(NString::primitive($value));

        if (!(preg_match($pattern, $value) === 1))
            throw new FormatException();

        $float = (float) $value;

        if (is_infinite($float))
            throw new OverflowException("Value in string is too large for an NFloat: " . $value);

        return self::get($float);
    }

    /**
     * Converts the string representation of a number to its NFloat equivalent.
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
     * NFloat equivalent to the $value parameter, if the conversion succeeded,
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
            $result = NFloat::get(0);
        }

        return NBool::get($successful);
    }

    /**
     * Returns a number that is negation of <code>this</code>.
     *
     * @return NFloat
     */
    public function negate()
    {
        return self::get(-$this->value);
    }

    /**
     * Returns a number that is the sum of <code>this + value</code>.
     *
     * @param int|float|NFloat $value The value to be added.
     * @return NFloat The sum.
     *
     * @throws ArgumentNullException if $value is null
     */
    public function plus($value)
    {
        if ($value === null)
            throw new ArgumentNullException(null, '$value');

        $result = $this->value + self::primitive($value);

        if (is_infinite($result))
            throw new OverflowException();

        return self::get($result);
    }

    /**
     * Returns a number that is the difference of <code>this - value</code>.
     *
     * @param int|float|NFloat $value The value to be subtracted.
     * @return NFloat The difference.
     *
     * @throws ArgumentNullException if $value is null
     */
    public function minus($value)
    {
        if ($value === null)
            throw new ArgumentNullException(null, '$value');

        $result = $this->value - self::primitive($value);

        if (is_infinite($result))
            throw new OverflowException();

        return self::get($result);
    }

    /**
     * Returns a number that is the product of <code>this * value</code>.
     *
     * @param int|float|NFloat $value The value to be multiplied.
     * @return NFloat The product.
     *
     * @throws ArgumentNullException if $value is null
     */
    public function times($value)
    {
        if ($value === null)
            throw new ArgumentNullException(null, '$value');

        $result = $this->value * self::primitive($value);

        if (is_infinite($result))
            throw new OverflowException();

        return self::get($result);
    }

    /**
     * Returns a number that is the quotient of <code>this / value</code>.
     *
     * @param int|float|NFloat $value The value to be divided.
     * @return NFloat The quotient.
     *
     * @throws ArgumentNullException if $value is null
     */
    public function divide($value)
    {
        if ($value === null)
            throw new ArgumentNullException(null, '$value');

        $result = $this->value / self::primitive($value);

        if (is_infinite($result))
            throw new OverflowException();

        return self::get($result);
    }

    /**
     * Returns a number that is the result of <code>this % value</code>.
     *
     * @param int|float|NFloat $value
     * @return NFloat
     *
     * @throws ArgumentNullException if $value is null
     */
    public function modulus($value)
    {
        if ($value === null)
            throw new ArgumentNullException(null, '$value');

        $result = $this->value % self::primitive($value);

        if (is_infinite($result))
            throw new OverflowException();

        return self::get($result);
    }

    /**
     * Returns a NBool that is the result of <code>this < value</code>.
     *
     * @param int|float|NFloat $value
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
     * @param int|float|NFloat $value
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
     * @param int|float|NFloat $value
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
     * @param int|float|NFloat $value
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
     * Converts this NFloat to a boolean primitive.
     *
     * @return boolean True if the value of the current instance is zero;
     * otherwise false.
     */
    public function bool()
    {
        return $this->value === 0.0;
    }

    /**
     * Returns the int value of this NFloat, if it is small enough.
     *
     * @return int
     *
     * @throws OverflowException if the NFloat is too large to fit in an int.
     */
    public function int()
    {
        if ($this->value > (float) PHP_INT_MAX)
            throw new OverflowException();

        return (int) $this->value;
    }

    /**
     * Returns the float value of this NFloat.
     *
     * @return float
     */
    public function float()
    {
        return $this->value;
    }

    /**
     * Returns the string value of this NFloat.
     * For example, if the value 42 then this would return "42".
     *
     * @return string
     */
    public function string()
    {
        return (string) $this->value;
    }

    /**
     * Converts this NFloat to an NBool instance.
     *
     * @return NBool True if the value of the current instance is zero;
     * otherwise false.
     */
    public function toBoolean()
    {
        return NBool::get($this->bool());
    }

    /**
     * Returns an NInt instance if possible.
     *
     * @return NInt
     *
     * @throws OverflowException if the NFloat is too large for an NInt.
     */
    public function toInteger()
    {
        return NInt::get($this->int());
    }

    /**
     * Returns this instance untouched.
     *
     * @return NFloat
     */
    public function toFloat()
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
        return NString::get($this->string());
    }
}