<?php

namespace System;

//require_once dirname(__FILE__) . '/IObject.php';

interface IComparable
{
    public function compareTo(IObject $object = null);
}
