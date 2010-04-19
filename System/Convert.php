<?php

namespace System;

final class Convert
{
    public static function toBoolean($value)
    {
        if ($value instanceof NBoolean)
            return $value;

        if ($value instanceof IConvertible)
            return $value->toBoolean();

        // Some sort of exception.
    }

    
}
