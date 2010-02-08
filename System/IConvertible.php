<?php

// TODO Need an InvalidCastException type to handle meaningless conversions.
// Throw regular exception for now.

namespace System;

interface IConvertible
{

    public function toNativeArray();
    public function toNativeBoolean();
    public function toNativeInteger();
    public function toNativeString();

}