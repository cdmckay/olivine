<?php

namespace System;

class NBoolean
    extends NObject
    implements IComparable, IFormattable, IConvertible, IEquatable
{
    private $value = false;

    public function NBoolean($value = false)
    {
        $this->value = (bool) $value;
    }

    public function getHashCode()
    {
        return $this->value ? new NInteger(1) : new NInteger(0);
    }

}
