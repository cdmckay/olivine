<?php

namespace System;

//require_once dirname(__FILE__) . '/IComparable.php';
//require_once dirname(__FILE__) . '/IFormattable.php';
//require_once dirname(__FILE__) . '/IConvertible.php';
//require_once dirname(__FILE__) . '/IEnumerable.php';
//require_once dirname(__FILE__) . '/IEquatable.php';
//require_once dirname(__FILE__) . '/NObject.php';

final class NString
    extends NObject
    implements IComparable, ICloneable, IConvertible, IEnumerable, IEquatable
{
    const EMPTY_STRING = "";

    private $value = null;

    public function __construct($value)
    {
        if (!is_string($value))
            throw new ArgumentException('$value must be a string', '$value');

        $this->value = $value;
    }

    public function __clone()
    {
        
    }

    public function compareTo(IObject $object)
    {
        
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

}
