<?php

/*
 * (c) Copyright 2010 Cameron McKay
 *
 * This file is part of Olivine.
 *
 * Olivine is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Olivine is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with Olivine.  If not, see <http://www.gnu.org/licenses/>.
 */

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