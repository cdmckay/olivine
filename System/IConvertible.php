<?php

namespace System;

interface IConvertible
{

    // To PHP native types.
    public function bool();
    public function int();
    public function float();
    public function string();

    // To Olivine types.
    public function toBoolean();
    public function toInteger();
    public function toFloat();

}