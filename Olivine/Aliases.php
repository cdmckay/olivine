<?php

use \System\NObject;
use \System\NBoolean;
use \System\NNumber;
use \System\NString;

function _bool($var)
{
    return NBoolean::get($var);
}

function _number($var)
{
    return NNumber::get($var);
}

function _string($var)
{
    return NString::get($var);
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
        return _number($var);
    if (is_string($var))
        return _string($var);    

    throw new \System\ArgumentException();
}

