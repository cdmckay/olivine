<?php

namespace System;

class ArgumentException extends NException
{
    private $paramName;

    public function __construct(
            $message = null,
            $paramName = null,
            NException $innerException = null)
    {
        if ($message == null)
        {
            $message = "An invalid argument was specified";
            $message .= $paramName == null ? "." : (": " . $paramName);
        }

        parent::__construct($message, $errorCode, $innerException);
        $this->paramName = $paramName;
    }

    public function getParamName()
    {
        return $this->paramName;
    }

}