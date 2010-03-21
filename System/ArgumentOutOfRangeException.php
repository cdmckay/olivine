<?php

namespace System;

class ArgumentOutOfRangeException extends ArgumentException
{    
    public function __construct(
            $message = null,
            $paramName = null,
            NException $innerException = null)
    {
        if ($message == null)
        {
            $message = "Argument out of range";
            $message .= $paramName == null ? "." : (": " . $paramName);
        }

        parent::__construct($message, $paramName, $innerException);
    }

}