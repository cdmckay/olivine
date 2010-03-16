<?php

namespace System;

final class Environment
    extends NObject
{
    private function __construct()
    {
        // Static class
    }

    private static $newline = null;

    public static function getNewLine()
    {
        if (self::$newline === null) self::$newline = NString::get(PHP_EOL);
        return self::$newline;
    }

    /**
     * Terminates this process and gives the underlying operating system
     * the specified exit code.
     * 
     * @param NNumber $exitCode
     */
    public static function terminate(NNumber $exitCode)
    {
        exit($exitCode->intValue());
    }
}
