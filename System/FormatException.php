<?php

namespace System;

class FormatException extends SystemException
{
    public function __construct(
            $message = "Invalid format.",           
            NException $innerException = null)
    {
        parent::__construct($message, 0, $innerException);
    }

}