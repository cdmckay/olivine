<?php

namespace System;

interface IConvertible
{

    // To PHP native types.
    public function boolValue();
    public function intValue();
    public function floatValue();
    public function stringValue();

    // To Olivine types.
    public function toBoolean();
    public function toInteger();
    public function toFloat();    

}