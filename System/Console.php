<?php

namespace System;

final class Console
    extends NObject
{
    private function __construct()
    {
        // Static class
    }

    public static function write(IObject $value)
    {
        echo $value->toString()->string();
    }

    public static function writeLine(IObject $value)
    {
        echo $value->toString()->concat(Environment::getNewLine())->string();
    }

    public static function writeFormat(NString $format /*, $arg0, $arg1, ... */)
    {
//        $func_args = func_get_args();
//        $slice_args = array_slice($func_args, 1);
//        echo NString::format($format, $slice);
    }
}