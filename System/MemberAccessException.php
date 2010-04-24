<?php

namespace System;

class MemberAccessException extends SystemException
{
    public function __construct(
            $message = null,
            NException $innerException = null)
    {
        if (!$message) $message = "Cannot access member";
        parent::__construct($message, 0, $innerException);
    }

}