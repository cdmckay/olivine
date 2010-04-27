<?php

namespace System;

interface INumber
{
    public function isLessThan($value);
    public function isLessThanOrEqualTo($value);
    public function isGreaterThan($value);
    public function isGreaterThanOrEqualTo($value);
    public function divide($value);
    public function times($value);
    public function plus($value);
    public function minus($value);
    public function modulus($value);
}