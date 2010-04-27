<?php

namespace System;

final class Math extends NObject
{
    public static function ceiling($value)
    {
        
    }

    public static function floor($value)
    {
        
    }

    public static function round($value, $decimals)
    {

    }

    public static function min($val1, $val2)
    {
        $a = NInt::get($val1);
        $b = NInt::get($val2);

        return NInt::get(min($a, $b));
    }

    public static function max($val1, $val2)
    {
        $a = NInt::get($val1);
        $b = NInt::get($val2);

        return NInt::get(max($a, $b));
    }    
}