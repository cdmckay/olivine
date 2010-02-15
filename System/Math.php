<?php

namespace System;

final class Math
{
    public static function ceiling(NNumber $value)
    {
        $val = $value->stringValue();
        $ret = $val;

        if (($pos = strpos($val, '.')) !== false)
        {
            if ($val[$pos + 1] != 0 && $val[0] != '-')
                $ret = bcadd(substr($val, 0, $pos), 1, 0);
            else
                $ret = substr($val, 0, $pos);
        }

        return NNumber::get($ret);
    }

    public static function floor(NNumber $value)
    {
        $val = $value->stringValue();
        $ret = $val;

        if (($pos = strpos($val, '.')) !== false)
        {
            if ($val[$pos + 1] != 0 && $val[0] == '-')
                $ret = bcsub(substr($val, 0, $pos), 1, 0);
            else
                $ret = substr($val, 0, $pos);
        }

        return NNumber::get($ret);
    }

    public static function round(NNumber $value, NNumber $decimals)
    {

    }

}