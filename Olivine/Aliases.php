<?php

use \System\NObject;
use \System\NBoolean;
use \System\NNumber;
use \System\NFloat;
use \System\NString;

function _bool($var)
{
    return NBoolean::get($var);
}

function _true()
{
    return NBoolean::get(true);
}

function _false()
{
    return NBoolean::get(false);
}

function _num($var)
{
    return NNumber::get($var);
}

function _string($var)
{
    return new NString($var);
}

function _object()
{
    return new NObject();
}

function is($var = null)
{
    if (is_bool($var))
        return _bool($var);
    if (is_int($var) || is_float($var))
        return _num($var);
    if (is_string($var))
        return _string($var);    

    throw new \System\ArgumentException();
}
