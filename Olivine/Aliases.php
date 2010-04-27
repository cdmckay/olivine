<?php

use \System\NObject;
use \System\NBoolean;
use \System\NInt;
use \System\NFloat;
use \System\NString;

/**
 * Returns an NBoolean instance.
 *
 * @param bool $var
 * @return NBoolean
 */
function _bool($var)
{
    return NBoolean::get($var);
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

