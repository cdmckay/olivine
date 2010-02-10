<?php

namespace System;

class InvalidCastException extends NException
{    
    public function __construct(
            $message = "Cannot cast from source type to destination type.",
            $errorCode = 0,
            NException $innerException = null)
    {
        parent::__construct($message, $errorCode, $innerException);
    }   
    
}
