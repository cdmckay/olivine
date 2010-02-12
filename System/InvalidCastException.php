<?php

namespace System;

//require_once dirname(__FILE__) . '/NException.php';
//require_once dirname(__FILE__) . '/SystemException.php';

class InvalidCastException extends SystemException
{    
    public function __construct(
            $message = "Cannot cast from source type to destination type.",
            $errorCode = 0,
            NException $innerException = null)
    {
        parent::__construct($message, $errorCode, $innerException);
    }   
    
}
