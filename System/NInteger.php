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

    public function __construct($value = 0)
    {
        $this->value = (int) $value;
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

}
