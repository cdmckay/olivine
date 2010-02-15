<?php

namespace System;

class ArithmeticException extends SystemException
{
    public function __construct(
            $message = "The arithmetic operation is not allowed.",
            NException $innerException = null)
    {
        parent::__construct($message, 0, $innerException);
    }

}