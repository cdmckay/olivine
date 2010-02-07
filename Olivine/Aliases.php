<?php

namespace Olivine;

function _bool($var)
{
    return new Boolean($var);
}

function _int($var)
{
    return new Integer($var);
}

function _float($var)
{
    return new Float($var);
}

function _string($var)
{
    return new String($var);
}

function _object()
{
    return new Object();
}

function _($var)
{
    if (is_bool($var))
        return _bool($var);
    if (is_int($var))
        return _int($var);
    if (is_float($var))
        return _float($var);
    if (is_string($var))
        return _string($var);

    return _object();
}
