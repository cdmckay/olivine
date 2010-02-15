<?php

namespace System;

final class Math
{
    public static function ceiling(NNumber $value)
    {
        $val = $value->stringValue();

        if (($pos = strpos($val, '.')) !== false)
        {
            if ($val[$pos + 1] != 0 && $val[0] != '-')
                return bcadd(substr($val, 0, $pos), 1, 0);
            else
                return substr($val, 0, $pos);
        }

        return NNumber::get($val);
    }

    public static function floor(NNumber $value)
    {
        $val = $value->stringValue();

        if (($pos = strpos($val, '.')) !== false)
        {
            if ($val[$pos + 1] != 0 && $val[0] == '-')
                return bcsub(substr($val, 0, $pos), 1, 0);
            else
                return substr($val, 0, $pos);
        }

        return NNInteger::get($val);
    }

    public static function round(NNumber $value, NNumber $decimals)
    {

    }

}