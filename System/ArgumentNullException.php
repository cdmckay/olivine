<?php

namespace System;

class ArgumentNullException extends ArgumentException
{    
    public function __construct(
            $message = null,
            $paramName = null,
            NException $innerException = null)
    {
        if ($message == null)
        {
            $message = "Argument cannot be null";
            $message .= $paramName == null ? "." : (": " . $paramName);
        }

        parent::__construct($message, $paramName, $innerException);
    }

}