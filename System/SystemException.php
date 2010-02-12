<?php

namespace System;

//require_once dirname(__FILE__) . '/NException.php';

class SystemException extends NException
{
    public function __construct(
            $message = "A system error has occurred.",
            $errorCode = 0,
            NException $innerException = null)
    {
        parent::__construct($message, $errorCode, $innerException);
    }

}

