<?php

namespace System;

//require_once dirname(__FILE__) . '/IComparable.php';
//require_once dirname(__FILE__) . '/IConvertible.php';
//require_once dirname(__FILE__) . '/IEquatable.php';
//require_once dirname(__FILE__) . '/IFormattable.php';
//require_once dirname(__FILE__) . '/NInteger.php';
//require_once dirname(__FILE__) . '/NObject.php';

final class NBoolean
    extends NObject
    implements IComparable, IConvertible, IFormattable, IEquatable
{
    private static $falseString = "false";
    private static $trueString = "true";

    private static $falseNString;
    private static $trueNString;

    public static function getFalseString()
    {
        if (self::$falseNString == null)
            self::$falseNString = new NString("false");

        return self::$falseNString;
    }

    public static function getTrueString()
    {
        if (self::$trueNString == null)
            self::$trueNString = new NString("true");

        return self::$trueNString;
    }

    private $value = false;

    // These are the cached true and false instances.
    private static $trueInstance;
    private static $falseInstance;

    private function __construct($value)
    {
        $this->value = $value;
    }

    public static function get($value)
    {
        if (!is_bool($value))
            throw new ArgumentException('$value must be a bool', '$value');

        if ($value)
        {
            if (!isset(NBoolean::$trueInstance))
                NBoolean::$trueInstance = new NBoolean(true);

            return NBoolean::$trueInstance;
        }
        else
        {
            if (!isset(NBoolean::$falseInstance))
                NBoolean::$falseInstance = new NBoolean(false);

            return NBoolean::$falseInstance;
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
     * This method returns greather than 0 when the instance is true and
     * $object is false, or if $object is null.
     *
     * @param NObject $object
     * @return NInteger
     */
    public function compareTo(IObject $object)
    {
        // TODO We need an ArgumentException.
        if (!($object instanceof NBoolean))
            throw new ArgumentException('$object is not an NBoolean', '$object');

        if ($object === null)
            return new NInteger(1);

        $o1 = $this->boolValue();
        $o2 = $object->boolValue();

        if ($o1 === $o2)
            return new NInteger(0);

        if ($o1 === false && $o2 === true)
            return new NInteger(-1);

        if ($o1 === true && $o2 === false)
            return new NInteger(1);
    }

    /**
     *
     * @param IObject $object
     * @return NBoolean
     */
    public function equals(IObject $object)
    {
        return $object instanceof NBoolean
                && $this->toNativeBoolean() === $object->bool();
    }

    /**
     * Returns the hash code for this instance.
     *
     * The NBoolean class implements true as the integer, 1, and false as
     * the integer, 0. However, a particular programming language might
     * represent true and false with other values.
     *
     * @return NInteger
     */
    public function getHashCode()
    {
        return $this->value ? new NInteger(1) : new NInteger(0);
    }    

    /**
     * Converts the specified string representation of a logical value to
     * its NBoolean equivalent.
     *
     * The value parameter, optionally preceded or trailed by white space,
     * must contain either getTrueString() or getFalseString(); otherwise, an exception
     * is thrown. The comparison is case-insensitive.
     *
     * @param NString $value A string containing the value to convert.
     * @return NBoolean True if value is equivalent to getTrueString(); otherwise, false.
     */
    public static function parse($value)
    {
        if ($value == null)
            throw new ArgumentNullException(null, '$value');

        if (!($value instanceof NString))
            throw new ArgumentException('$value is not an NString', '$value');

        $str = trim($value->stringValue());

        if ($str === self::$trueString)
            return self::$trueInstance;

        if ($str === self::$falseString)
            return self::$falseInstance;

        throw new FormatException();
    }

    /**
     * Converts the value of this instance to its equivalent string
     * representation (either "True" or "False").
     *
     * @return NString
     */
    public function toString()
    {
        return $this->value ? new NString("True") : new NString("False");
    }

    public function boolValue()
    {
        return $this->value;
    }

    public function intValue()
    {
        return $this->value ? 1 : 0;
    }

    public function floatValue()
    {
        return (float) $this->value ? 1 : 0;
    }

    public function stringValue()
    {
        return (string) $this->value;
    }

}
