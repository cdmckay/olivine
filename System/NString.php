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
        if ($ignoreCase === null) $ignoreCase = false;

        $a = $strA === null ? null : $strA->stringValue();
        $b = $strB === null ? null : $strB->stringValue();

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

    public function indexOf(NString $value, NNumber $startIndex = null, NNumber $count = null)
    {
        
    }

    public function indexOfAny()
    {
        throw new NotImplementedException();
    }

    public function inequality(NString $a = null, NString $b = null)
    {
        
    }

    public function insert(NNumber $startIndex, NString $value = null)
    {
        
    }

    public function intern(NString $str = null)
    {
        throw new NotImplementedException();
    }

    public function isInterned(NString $str = null)
    {
        throw new NotImplementedException();
    }

    public static function isNullOrEmpty(NString $value = null)
    {
        
    }

    public static function isNullOrWhiteSpace(NString $value = null)
    {
        
    }

    public static function join()
    {
        // Requires collections support.
        throw new NotImplementedException();
    }

    public function lastIndexOf(NString $value, NNumber $startIndex = null, NNumber $count = null)
    {

    }

    public function padLeft(NNumber $totalWidth, NString $paddingChar)
    {

    }

    public function padRight(NNumber $totalWidth, NString $paddingChar)
    {

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

    public function toSentenceCase()
    {
        return self::get(ucfirst($this->value));
    }

    public function toTitleCase()
    {
        return self::get(ucwords($this->value));
    }

    public function wordWrap(NNumber $width, NString $newLine = null, NBoolean $cut = null)
    {
        if ($newLine === null) $newLine = Environment::getNewLine();
        if ($cut === null) $cut = NBoolean::get(false);

        return self::get(wordwrap(
                $this->value,
                $width->intValue(),
                $newLine->stringValue(),
                $cut->boolValue()));
    }

    public function wordCount()
    {
        return NNumber::get(wordcount($this->value));
    }
}
