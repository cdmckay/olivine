<?php

namespace System;

class NotImplementedException extends SystemException
{
    public function __construct(
            $message = "",           
            NException $innerException = null)
    {
        parent::__construct($message, 0, $innerException);
    }

}