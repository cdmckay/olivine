<?php

namespace System;

final class Math
{
    public static function ceiling(NNumber $value)
    {
        $val = $value->string();
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
        $val = $value->string();
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

    public static function min(NNumber $val1, NNumber $val2)
    {
        if ($val1->isLessThan($val2)->bool()) return $val1;
        return $val2;
    }

    public static function max(NNumber $val1, NNumber $val2)
    {
        if ($val1->isGreaterThan($val2)->bool()) return $val1;
        return $val2;
    }

}