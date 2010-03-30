<?php

namespace System;

final class NString
    extends NObject
    implements IComparable, ICloneable, IConvertible, IEnumerable
{
    private static $emptyString;

    public static function getEmpty()
    {
        if (self::$emptyString == null)
            self::$emptyString = self::get('');
        
        return self::$emptyString;
    }

    private $value = null;
    private $length = 0;

    private function __construct($value)
    {        
        $this->value = $value;
        $this->length = NNumber::get(strlen($value));
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

    /**
     * Compares two specified NString objects, ignoring or honoring their case,
     * and returns an integer that indicates their relative position in the
     * sort order.
     *
     * Returns less than zero if $strA is less than $strB.
     *
     * Returns zero $strA equals $strB.
     *
     * Return greater than zero if $strA is greater than $strB.
     *
     * @param NString $strA The first string to compare.
     * @param NString $strB The second string to compare.
     * @param NBoolean $ignoreCase True to ignore case during comparision; false otherwise.
     * @return NNumber An NNumber that indicates the lexical relationship
     * between the two comparands.
     */
    public static function compare(NString $strA = null, NString $strB = null, NBoolean $ignoreCase = null)
    {
        if ($ignoreCase === null) $ignoreCase = NBoolean::get(false);

        $a = $strA === null ? null : $strA->stringValue();
        $b = $strB === null ? null : $strB->stringValue();

        if ($a === null && $b === null) return NNumber::get(0);
        if ($a === null) return NNumber::get(-1);
        if ($b === null) return NNumber::get(1);

        return NNumber::get($ignoreCase->boolValue() ? strcasecmp($a, $b) : strcmp($a, $b));
    }

    /**
     * Compares this instance with a specified NString object and indicates
     * whether this instance precedes, follows, or appears in the same position
     * in the sort order as the specified NString.
     *
     * Returns less than zero if $strB precedes this instance.
     *
     * Returns zero if this instance has the same position in the sort order
     * as $strB.
     *
     * Returns greater than zero if this instance follows $strB, or $strB is
     * a null reference.
     *
     * @param IObject $strB
     * @return NNumber An integer that indicates whether this instance precedes,
     * follows, or appears in the same position in the sort order as the
     * value parameter.
     */
    public function compareTo(IObject $strB = null)
    {
        if ($strB === null) return NNumber::get(1);
        return NNumber::get(strcmp($this->value, $strB->toString()->stringValue()));
    }

    /**
     * Concatenates this NString with one or more instances of NString, or the NString
     * representations of the values of one or more instances of IObject.
     *
     * @param IObject $arg0 The first IObject.
     * @param IObject $arg1 The second IObject.
     * @param IObject $arg2 The third IObject.
     * @return NString The concatenated NString representations of the
     * values of $arg0, $arg1, and $arg2.
     */
    public function concat(IObject $arg0, IObject $arg1 = null, IObject $arg2 = null)
    {
        $str = $this->value . $arg0;
        if ($arg1 !== null) $str .= $arg1;
        if ($arg2 !== null) $str .= $arg2;
        return self::get($str);
    }

    /**
     * Concatenates one or more instances of NString, or the NString
     * representations of the values of one or more instances of IObject.
     *
     * @param IObject $arg0 The first IObject.
     * @param IObject $arg1 The second IObject.
     * @param IObject $arg2 The third IObject.
     * @param IObject $arg3 The fourth IObject.
     * @return NString The concatenated NString representations of the
     * values of $arg0, $arg1, $arg2, and $arg3.
     */
    public static function staticConcat(IObject $arg0, IObject $arg1 = null, IObject $arg2 = null, IObject $arg3 = null)
    {
        return $arg0->toString()->concat($arg1, $arg2, $arg3);
    }   

    /**
     * Returns a value indicating whether the specified NString object
     * occurs within this string.
     *
     * @param NString $value
     * @return NBoolean True if the value parameter occurs within this string,
     * or if value is the empty string (""); otherwise, false.
     *
     * @throws ArgumentNullException if value is a null reference
     */
    public function contains(NString $value = null, NBoolean $ignoreCase = null)
    {
        if ($value === null)
            throw new ArgumentNullException('$value must not be null', '$value');

        if ($value->stringValue() === '')
            return NBoolean::get(true);

        if ($ignoreCase === null) $ignoreCase = NBoolean::get(false);

        return $ignoreCase->boolValue()
                ? NBoolean::get(stripos($this->value, $value->stringValue()) !== false)
                : NBoolean::get(strpos($this->value, $value->stringValue()) !== false);
    }

    public static function copy(NString $str)
    {
        return self::get($str->stringValue());
    }

    /**
     * Determines whether the end of this string matches the specified string.
     *
     * @param NString $value An NString object to compare to.
     * @param NBoolean $ignoreCase  True to ignore case when comparing this
     * instance and value; otherwise, false.
     * @return NBoolean True if the $value parameter matches the end of this string;
     * otherwise, false.
     *
     * @throws ArgumentNullException if $value is a null reference.
     */
    public function endsWith(NString $value = null, NBoolean $ignoreCase = null)
    {
        if ($value === null)
            throw new ArgumentNullException('$value must not be null', '$value');

        if ($ignoreCase === null) $ignoreCase = NBoolean::get(false);

        $expected = $this->length->minus($value->getLength());
        return $this->lastIndexOf($value, null, null, $ignoreCase)->equals($expected);
    }

    public function equals(IObject $object = null)
    {
        return $this->compareTo($object)->equals(NNumber::get(0));
    }

    public static function staticEquals(IObject $object1 = null, IObject $object2 = null)
    {
        if ($object1 === null && $object2 === null) return NBoolean::get(true);
        if ($object1 !== null) return $object1->toString()->equals($object2);
        if ($object2 !== null) return $object2->toString()->equals($object1);
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

    public function getLength()
    {
        return $this->length;
    }

    public function indexOf(NString $value = null,
            NNumber $startIndex = null, NNumber $count = null,
            NBoolean $ignoreCase = null)
    {
        if ($value === null)
            throw new ArgumentNullException(null, '$value');        

        if ($startIndex !== null && $startIndex->isLessThan(NNumber::get(0))->boolValue())
            throw new ArgumentOutOfRangeException('$startIndex must be nonnegative', '$startIndex');

        if ($startIndex !== null && $startIndex->isGreaterThan($this->length)->boolValue())
            throw new ArgumentOutOfRangeException('$startIndex must be less than the length of this instance', '$startIndex');

        if ($count !== null && $count->isLessThan(NNumber::get(0))->boolValue())
            throw new ArgumentOutOfRangeException('$count must be nonnegative', '$count');

        if ($startIndex === null) $startIndex = NNumber::get(0);
        if ($count === null) $count = $this->length->minus($startIndex);
        if ($ignoreCase === null) $ignoreCase = NBoolean::get(false);

        if ($value->getLength()->equals(NNumber::get(0))->boolValue())
            return $startIndex;
        
        $str = $this->substring($startIndex, $count);

        $position = $ignoreCase->boolValue()
                ? stripos($str->stringValue(), $value->stringValue())
                : strpos($str->stringValue(), $value->stringValue());

        if ($position === false) return NNumber::get(-1);

        return $startIndex->plus(NNumber::get($position));
    }

    public function indexOfAny()
    {
        throw new NotImplementedException();
    }    

    public function insert(NNumber $startIndex, NString $value = null)
    {
        if ($value === null)
            throw new ArgumentNullException(null, '$value');

        if ($startIndex->isLessThan(NNumber::get(0))->boolValue())
            throw new ArgumentOutOfRangeException('$startIndex must be nonnegative', '$startIndex');

        if ($startIndex->isGreaterThan($this->length)->boolValue())
            throw new ArgumentOutOfRangeException('$startIndex must be less than the length of this string', '$startIndex');

        return $this->substring(is(0), $startIndex)->concat($value, $this->substring($startIndex));
    }

    public function intern(NString $str = null)
    {
        throw new NotImplementedException();
    }

    public function isInterned(NString $str = null)
    {
        throw new NotImplementedException();
    }

    public function isEmpty()
    {
        return $this->equals(self::getEmpty());
    }

    public static function isNullOrEmpty(NString $value = null)
    {
        return NBoolean::get($value === null)->orElse($value->isEmpty());
    }

    public static function isNullOrWhiteSpace(NString $value = null)
    {
        return NBoolean::get($value === null)->orElse($value->trim()->isEmpty());
    }

    public static function join()
    {        
        throw new NotImplementedException();
    }

    public function lastIndexOf(NString $value = null, 
            NNumber $startIndex = null, NNumber $count = null,
            NBoolean $ignoreCase = null)
    {
        if ($value === null)
            throw new ArgumentNullException(null, '$value');       

        if ($startIndex !== null && $startIndex->isLessThan(NNumber::get(0))->boolValue())
            throw new ArgumentOutOfRangeException('$startIndex must be nonnegative', '$startIndex');

        if ($startIndex !== null && $startIndex->isGreaterThan($this->length)->boolValue())
            throw new ArgumentOutOfRangeException('$startIndex must be less than the length of this instance', '$startIndex');

        if ($count !== null && $count->isLessThan(NNumber::get(0))->boolValue())
            throw new ArgumentOutOfRangeException('$count must be nonnegative', '$count');

        if ($startIndex === null) $startIndex = $this->length;
        if ($count === null) $count = $this->length;
        if ($ignoreCase === null) $ignoreCase = NBoolean::get(false);
        
        $str = $this->reverse();
        $val = $value->reverse();
        $offset = $this->length->minus($startIndex);
        $index = $str->indexOf($val, $offset, $count, $ignoreCase);
        return $this->length->minus($index)->minus($val->getLength());
    }

    public function padLeft(NNumber $totalWidth, NString $paddingChar = null)
    {
        if ($paddingChar === null) $paddingChar = self::get(' ');

        $padded = str_pad($this->value,
                $totalWidth->intValue(),
                $paddingChar->stringValue(),
                STR_PAD_LEFT);

        return self::get($padded);
    }

    public function padRight(NNumber $totalWidth, NString $paddingChar = null)
    {
        if ($paddingChar === null) $paddingChar = self::get(' ');

        $padded = str_pad($this->value,
                $totalWidth->intValue(),
                $paddingChar->stringValue(),
                STR_PAD_RIGHT);

        return self::get($padded);
    }

    public function remove(NNumber $startIndex, NNumber $count = null)
    {
        if ($startIndex->isLessThan(NNumber::get(0))->boolValue())
            throw new ArgumentOutOfRangeException('$startIndex must be nonnegative', '$startIndex');

        if ($startIndex->isGreaterThan($this->length)->boolValue())
            throw new ArgumentOutOfRangeException('$startIndex must be less than the length of this string', '$startIndex');

        if ($count !== null && $count->isLessThan(NNumber::get(0))->boolValue())
            throw new ArgumentOutOfRangeException('$count must be nonnegative', '$count');

        
    }

    public function replace(NString $oldValue = null, NString $newValue = null)
    {

    }   

    /**
     * Inverts the order of the characters in the string.
     *
     * @return NString A string whose characters correspond to those of the
     * original string but in reverse order.
     */
    public function reverse()
    {
        return self::get(strrev($this->value));
    }

    public function split()
    {
        throw new NotImplementedException();
    }

    public function startsWith(NString $value = null, NBoolean $ignoreCase = null)
    {
        
    }

    /**
     * Retrieves a substring from this instance. The substring starts at a
     * specified character position and has a specified length.
     *
     * Note that this method differs from the .NET version in that it will not
     * throw an exception if the $startIndex + $length position is not within
     * this instance.
     *
     * @param NNumber $startIndex The zero-based starting character position
     * of a substring in this instance.
     * @param NNumber $length The number of characters in the substring.
     * @return NString A string that is equivalent to the substring of
     * length $length that begins at $startIndex in this instance, or the empty
     * string if $startIndex is equal to the length of this instance and length
     * is zero.
     */
    public function substring(NNumber $startIndex, NNumber $length = null)
    {
        if ($length === null) $length = $this->length;
        if ($startIndex->equals($this->length)->boolValue())
                return self::getEmpty();

        return self::get(substr($this->value,
                $startIndex->intValue(),
                $length->intValue()));
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
}
