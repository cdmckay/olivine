<?php

namespace System;

final class NString
    extends NObject
    implements IComparable, ICloneable, IConvertible, IEnumerable
{
    private static $internPool = array();
    private static $emptyString;

    /**
     * Represents the empty string.
     *
     * @return NString
     */
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

    /**
     * Returns an NString instance for a given string.
     *
     * @param string $value
     * @return NString
     */
    public static function get($value)
    {
        if ($value instanceof self)
            return $value;

        if (!is_string($value))
            throw new ArgumentException('$value must be a string or an NString', '$value');

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
     * @param string|NString $strA The first string to compare.
     * @param string|NString $strB The second string to compare.
     * @param bool|NBoolean $ignoreCase True to ignore case during comparision; false otherwise.
     * @return NNumber An NNumber that indicates the lexical relationship
     * between the two comparands.
     */
    public static function compare($strA, $strB, $ignoreCase = false)
    {
        $ignoreCase = NBoolean::get($ignoreCase)->bool();

        $a = $strA === null ? null : self::get($strA)->string();
        $b = $strB === null ? null : self::get($strB)->string();

        if ($a === null && $b === null) return NNumber::get(0);
        if ($a === null) return NNumber::get(-1);
        if ($b === null) return NNumber::get(1);

        return NNumber::get($ignoreCase ? strcasecmp($a, $b) : strcmp($a, $b));
    }

    /**
     * Compares this instance with a specified NString object and indicates
     * whether this instance precedes, follows, or appears in the same position
     * in the sort order as the specified NString.
     *
     * Returns less than zero if $str precedes this instance.
     *
     * Returns zero if this instance has the same position in the sort order
     * as $str.
     *
     * Returns greater than zero if this instance follows $strB, or $strB is
     * a null reference.
     *
     * @param string|NString $str
     * @param bool|NBoolean $ignoreCase True to ignore case during comparision; false otherwise.
     * @return NNumber An integer that indicates whether this instance precedes,
     * follows, or appears in the same position in the sort order as the
     * value parameter.
     */
    public function compareTo($str, $ignoreCase = false)
    {
        if ($str === null) return NNumber::get(1);
        $a = $this->value;
        $b = self::get($str)->string();
        $ignoreCase = NBoolean::get($ignoreCase)->bool();
        return NNumber::get($ignoreCase ? strcasecmp($a, $b) : strcmp($a, $b));
    }

    /**
     * Concatenates this NString with one or more instances of NString, or the NString
     * representations of the values of one or more instances of IObject.
     *
     * @param bool|int|float|string|IObject $arg0 The first object.
     * @param bool|int|float|string|IObject $arg1 The second object.
     * @param bool|int|float|string|IObject $arg2 The third object.
     * @return NString The concatenated NString representations of the
     * values of $arg0, $arg1, and $arg2.
     *
     * @throws ArgumentNullException if any argument is null.
     * @throws ArgumentException if any argument is an array or an object
     * that does not implement IObject.
     */
    public function concat($arg0, $arg1 = '', $arg2 = '')
    {
        if ($arg0 === null)        
            throw new ArgumentNullException(null, '$arg0');

        if ($arg1 === null)
            throw new ArgumentNullException(null, '$arg1');

        if ($arg2 === null)
            throw new ArgumentNullException(null, '$arg2');

        if (is_array($arg0) || (is_object($arg0) && !($arg0 instanceof IObject)))
            throw new ArgumentException("Cannot concatenate primitive objects or arrays", '$arg0');

        if (is_array($arg1) || (is_object($arg1) && !($arg1 instanceof IObject)))
            throw new ArgumentException("Cannot concatenate primitive objects or arrays", '$arg1');

        if (is_array($arg2) || (is_object($arg2) && !($arg2 instanceof IObject)))
            throw new ArgumentException("Cannot concatenate primitive objects or arrays", '$arg2');

        $str = $this->value;
        $str .= $arg0;
        $str .= $arg1;
        $str .= $arg2;
        
        return self::get($str);
    }

    /**
     * Concatenates one or more instances of NString, or the NString
     * representations of the values of one or more instances of IObject.
     *
     * @param bool|int|float|string|IObject $arg0 The first IObject.
     * @param bool|int|float|string|IObject $arg1 The second IObject.
     * @param bool|int|float|string|IObject $arg2 The third IObject.
     * @param bool|int|float|string|IObject $arg3 The fourth IObject.
     * @return NString The concatenated NString representations of the
     * values of $arg0, $arg1, $arg2, and $arg3.
     *
     * @throws ArgumentNullException if any argument is null.
     * @throws ArgumentException if any argument is an array or an object
     * that does not implement IObject.
     */
    public static function staticConcat($arg0, $arg1 = '', $arg2 = '', $arg3 = '')
    {
        if ($arg0 === null)
            throw new ArgumentNullException(null, '$arg0');

        if ($arg1 === null)
            throw new ArgumentNullException(null, '$arg1');

        if ($arg2 === null)
            throw new ArgumentNullException(null, '$arg2');

        if ($arg3 === null)
            throw new ArgumentNullException(null, '$arg3');

        if (is_array($arg0) || (is_object($arg0) && !($arg0 instanceof IObject)))
            throw new ArgumentException("Cannot concatenate primitive objects or arrays", '$arg0');

        if (is_array($arg1) || (is_object($arg1) && !($arg1 instanceof IObject)))
            throw new ArgumentException("Cannot concatenate primitive objects or arrays", '$arg1');

        if (is_array($arg2) || (is_object($arg2) && !($arg2 instanceof IObject)))
            throw new ArgumentException("Cannot concatenate primitive objects or arrays", '$arg2');

        if (is_array($arg3) || (is_object($arg3) && !($arg3 instanceof IObject)))
            throw new ArgumentException("Cannot concatenate primitive objects or arrays", '$arg3');

        return self::get((string) $arg0)->toString()->concat($arg1, $arg2, $arg3);
    }   

    /**
     * Returns a value indicating whether the specified NString object
     * occurs within this string.
     *
     * @param string|NString $value
     * @return bool|NBoolean True if the value parameter occurs within this string,
     * or if value is the empty string (""); otherwise, false.
     *
     * @throws ArgumentNullException if value is a null reference
     */
    public function contains($value, $ignoreCase = false)
    {
        if ($value === null)
            throw new ArgumentNullException('$value must not be null', '$value');

        $value = self::get($value);
        $ignoreCase = NBoolean::get($ignoreCase);

        if ($value->string() === '')
            return NBoolean::get(true);        

        return $ignoreCase->bool()
                ? NBoolean::get(stripos($this->value, $value->string()) !== false)
                : NBoolean::get(strpos($this->value, $value->string()) !== false);
    }   

    /**
     * Determines whether the end of this string matches the specified string.
     *
     * @param string|NString $value A string object to compare to.
     * @param bool|NBoolean $ignoreCase  True to ignore case when comparing this
     * instance and value; otherwise, false.
     * @return NBoolean True if the $value parameter matches the end of this string;
     * otherwise, false.
     *
     * @throws ArgumentNullException if $value is a null reference.
     */
    public function endsWith($value, $ignoreCase = false)
    {
        if ($value === null)
            throw new ArgumentNullException('$value must not be null', '$value');

        $value = self::get($value);
        $ignoreCase = NBoolean::get($ignoreCase);

        $expected = $this->length->minus($value->getLength());
        return $this->lastIndexOf($value, null, null, $ignoreCase)->equals($expected);
    }

    /**
     * Determines whether this instance and a specified object, which must
     * also be a string or NString object, have the same value.
     *
     * @param mixed $value The string to compare to this instance.
     * @param bool|NBoolean $ignoreCase
     * @return NBoolean True if $value is a string and its value is the same as
     * this instance; otherwise, false.
     */
    public function equals($value, $ignoreCase = false)
    {
        if ($value === null || (!is_string($value) && !($value instanceof self)))
            return NBoolean::get(false);

        $value = self::get($value);
        return $this->compareTo($value, $ignoreCase)->equals(0);
    }

    /**
     * Determines whether two specified strings have the same value.
     *
     * @param string|NString $str1 The first string to compare, or null.
     * @param string|NString $str2 The second string to compare, or null.
     * @param bool|NBoolean $ignoreCase
     * @return NBoolean True if the value of the $str1 parameter is equal to the
     * value of the $str2 parameter; otherwise, false.
     */
    public static function staticEquals($str1, $str2, $ignoreCase = false)
    {
        $str1 = $str1 !== null ? self::get($str1) : null;
        $str2 = $str2 !== null ? self::get($str2) : null;

        if ($str1 === null && $str2 === null) return NBoolean::get(true);               
        if ($str1 !== null) return $str1->equals($str2, $ignoreCase);
        if ($str2 !== null) return $str2->equals($str1, $ignoreCase);
    }

    /**
     * Replaces the format item in a specified string with the string 
     * representation of a corresponding object in a specified array.
     *
     * @param string|NString $format A format string as defined by the PHP printf
     * function.
     * @param mixed $arg,... Zero or more objects to format.
     * @return NString A copy of $format in which the format items have been replaced by
     * the string representation of the corresponding $arg objects.
     */
    public static function format($format /*, $arg0, $arg1, ... */)
    {
        $format = self::get($format);
        $args = func_get_args();
        $args_slice = array_slice($args, 1);
        $fixed_args = array();
        foreach ($args_slice as $arg)
        {            
            if (false);
            else if ($arg instanceof NString)
            {
                $fixed_args[] = $arg->string();
            }
            else if ($arg instanceof NNumber)
            {
                $fixed_args[] = $arg->float();
            }
            else if ($arg instanceof IObject)
            {
                $fixed_args[] = $arg->toString()->string();
            }
            else
            {
                $fixed_args[] = $arg;
            }
        }
        return self::get(vsprintf($format->string(), $fixed_args));
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

        if ($startIndex !== null && $startIndex->isLessThan(NNumber::get(0))->bool())
            throw new ArgumentOutOfRangeException('$startIndex must be nonnegative', '$startIndex');

        if ($startIndex !== null && $startIndex->isGreaterThan($this->length)->bool())
            throw new ArgumentOutOfRangeException('$startIndex must be less than the length of this instance', '$startIndex');

        if ($count !== null && $count->isLessThan(NNumber::get(0))->bool())
            throw new ArgumentOutOfRangeException('$count must be nonnegative', '$count');

        if ($startIndex !== null && $count !== null
                && $startIndex->plus($count)->isGreaterThan($this->length)->bool())
            throw new ArgumentOutOfRangeException('$count must refer to a location within this instance', '$count');

        if ($startIndex === null) $startIndex = NNumber::get(0);
        if ($count === null) $count = $this->length->minus($startIndex);
        if ($ignoreCase === null) $ignoreCase = NBoolean::get(false);

        if ($value->getLength()->equals(NNumber::get(0))->bool())
            return $startIndex;
        
        $str = $this->substring($startIndex, $count);

        $position = $ignoreCase->bool()
                ? stripos($str->string(), $value->string())
                : strpos($str->string(), $value->string());

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

        if ($startIndex->isLessThan(NNumber::get(0))->bool())
            throw new ArgumentOutOfRangeException('$startIndex must be nonnegative', '$startIndex');

        if ($startIndex->isGreaterThan($this->length)->bool())
            throw new ArgumentOutOfRangeException('$startIndex must be less than the length of this string', '$startIndex');

        return $this->substring(is(0), $startIndex)->concat($value, $this->substring($startIndex));
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

        if ($startIndex !== null && $startIndex->isLessThan(NNumber::get(0))->bool())
            throw new ArgumentOutOfRangeException('$startIndex must be nonnegative', '$startIndex');

        if ($startIndex !== null && $startIndex->isGreaterThan($this->length)->bool())
            throw new ArgumentOutOfRangeException('$startIndex must be less than the length of this instance', '$startIndex');

        if ($count !== null && $count->isLessThan(NNumber::get(0))->bool())
            throw new ArgumentOutOfRangeException('$count must be nonnegative', '$count');

        if ($startIndex === null) $startIndex = $this->length;
        if ($count === null) $count = $startIndex;
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
                $totalWidth->int(),
                $paddingChar->string(),
                STR_PAD_LEFT);

        return self::get($padded);
    }

    public function padRight(NNumber $totalWidth, NString $paddingChar = null)
    {
        if ($paddingChar === null) $paddingChar = self::get(' ');

        $padded = str_pad($this->value,
                $totalWidth->int(),
                $paddingChar->string(),
                STR_PAD_RIGHT);

        return self::get($padded);
    }

    public function remove(NNumber $startIndex, NNumber $count = null)
    {
        if ($startIndex->isLessThan(NNumber::get(0))->bool())
            throw new ArgumentOutOfRangeException('$startIndex must be nonnegative', '$startIndex');

        if ($startIndex->isGreaterThan($this->length)->bool())
            throw new ArgumentOutOfRangeException('$startIndex must be less than the length of this string', '$startIndex');

        if ($count !== null && $count->isLessThan(NNumber::get(0))->bool())
            throw new ArgumentOutOfRangeException('$count must be nonnegative', '$count');

        
    }

    /**
     * Returns a new string in which all occurrences of a specified string in
     * the current instance are replaced with another specified string.
     * 
     * If $newValue is null, all occurrences of $oldValue are removed.
     * 
     * Because this method replaces left to right, it might replace a
     * previously inserted value when doing multiple replacements.
     *
     * @param NString $oldValue The string to be replaced.
     * @param NString $newValue The string to replace all occurrences of $oldValue.
     * @return NString A string that is equivalent to the current string except
     * that all instances of $oldValue are replaced with $newValue.
     *
     * @throws ArgumentNullException if $oldValue is a null reference.
     * @throws ArgumentException if $oldValue is the empty string.
     */
    public function replace(NString $oldValue = null, NString $newValue = null)
    {
        if ($oldValue === null)
            throw new ArgumentNullException(null, '$oldValue');

        if ($oldValue->isEmpty()->bool())
            throw new ArgumentException('$oldValue cannot be the empty string', '$oldValue');

        if ($newValue === null) $newValue = self::getEmpty();

        return self::get(str_replace(
                $oldValue->string(),
                $newValue->string(),
                $this->value));
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
        if ($length !== null && $startIndex->plus($length)->isGreaterThan($this->length)->bool())
                throw new ArgumentOutOfRangeException('$length must refer to a location within this instance', '$length');

        if ($length === null) $length = $this->length->minus($startIndex);
        if ($startIndex->equals($this->length)->bool())
                return self::getEmpty();

        return self::get(substr($this->value,
                $startIndex->int(),
                $length->int()));
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

    public function bool()
    {
        return (bool) $this->value;
    }

    public function int()
    {
        return (int) $this->value;
    }

    public function float()
    {
        return (float) $this->value;
    }

    public function string()
    {
        return $this->value;
    }

    public function toBoolean()
    {
        return NBoolean::parse($this);
    }

    public function toNumber()
    {
        return NNumber::parse($this);
    }

    public function toString()
    {
        return $this;
    }    
}
