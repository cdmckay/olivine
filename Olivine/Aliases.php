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

use \System\NObject;
use \System\NBool;
use \System\NInt;
use \System\NFloat;
use \System\NString;

/**
 * Returns an NBool instance.
 *
 * @param bool $var
 * @return NBool
 */
function _bool($var)
{
    return NBool::get($var);
}

/**
 * Returns an NInt instance.
 *
 * @param int $var
 * @return NInt
 */
function _int($var)
{
    return NInt::get($var);
}

/**
 * Returns an NFloat instance.
 *
 * @param float $var
 * @return NFloat
 */
function _float($var)
{    
    return NFloat::get($var);
}

/**
 * Returns an NString instance.
 *
 * @param string $var
 * @return NString
 */
function _string($var)
{
    return NString::get($var);
}

/**
 * Returns an NObject instance.
 *
 * @return NObject
 */
function _object()
{
    return new NObject();
}

/**
 * Returns an appropriate Olivine type depending on the argument.
 *
 * @param bool|int|float|string $var
 * @return <type>
 */
function is($var = null)
{
    if (is_bool($var))
        return _bool($var);
    if (is_int($var))
        return _int($var);
    if (is_float($var))
        return _float($var);
    if (is_string($var))
        return _string($var);    

    throw new \System\ArgumentException();
}

