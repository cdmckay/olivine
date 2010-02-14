<?php

namespace System;

final class NInteger
    extends NObject
    implements IComparable, IConvertible /* IFormattable */
{
    public static function getMaxValue()
    {
        return PHP_INT_MAX;
    }

    public static function getMinValue()
    {
        return -PHP_INT_MAX - 1;
    }

    private $value = 0;

    private function __construct($value = 0)
    {
        $this->value = $value;
    }

    public static function get($value)
    {
        if (!is_int($value))
            throw new ArgumentException('$value must be an int', '$value');

        return new NInteger($value);
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
     * @return NInteger A signed number indicating the relative values of
     * this instance and value.
     */
    public function compareTo(IObject $object = null)
    {
        if ($object === null)
            return new NInteger(1);

        if (!($object instanceof NInteger))
            throw new ArgumentException('$object is not an NInteger', '$object');

        $o1 = $this->intValue();
        $o2 = $object->intValue();
             
        if ($o1 < $o2) return new NInteger(-1);
        if ($o1 > $o2) return new NInteger(1);

        return new NInteger(0);
    }

    /**
     * Returns a value indicating whether this instance is equal to a
     * specified object.
     *
     * @param IObject $object An object to compare with this instance.
     * @return NBoolean True if obj is an instance of NInteger and equals
     * the value of this instance; otherwise, false.
     */
    public function equals(IObject $object = null)
    {
        return NBoolean::get($object instanceof NInteger
                && $this->intValue() === $object->intValue());
    }

    public function parse(NString $value)
    {

    }

    public function tryParse(NString $value, NBoolean &$result = null)
    {
        
    }
    
    public function boolValue()
    {
        return (bool) $this->value;
    }

    public function intValue()
    {
        return $this->value;
    }

    public function floatValue()
    {
        return (float) $this->value;
    }

    public function stringValue()
    {
        return (string) $this->value;
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
