<?php

namespace System;

class MissingMemberException extends MemberAccessException
{
    protected $className;
    protected $memberName;

    public function __construct(
            $message = null,
            $className = "",
            $memberName = "",
            NException $innerException = null)
    {
        if (!$message) $message = "Attempted to access a missing member";
        parent::__construct($message, $innerException);
        $this->className = $className;
        $this->memberName = $memberName;
    }

}