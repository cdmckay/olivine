<?php

namespace System;

class OverflowException extends ArithmeticException
{
    public function __construct(
            $message = "An overflow has occurred.",
            NException $innerException = null)
    {
        parent::__construct($message, $innerException);
    }

}