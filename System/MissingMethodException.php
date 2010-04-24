<?php

namespace System;

class MissingMethodException extends MissingMemberException
{    
    public function __construct(
            $message = null,
            $className = "",
            $memberName = "",
            NException $innerException = null)
    {
        if (!$message) $message = "Attempted to access a missing method";
        parent::__construct($message, $className, $memberName, $innerException);
    }

}