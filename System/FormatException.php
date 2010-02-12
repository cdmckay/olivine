<?php

namespace System;

//require_once dirname(__FILE__) . '/SystemException.php';

class FormatException extends SystemException
{
    public function __construct(
            $message = "Invalid format.",           
            NException $innerException = null)
    {
        parent::__construct($message, 0, $innerException);
    }

}