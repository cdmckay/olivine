<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__) . '/../../Olivine/Framework.php';

use \System\Math;
use \System\NNumber;

Olivine::import("System");

class MathTest extends PHPUnit_Framework_TestCase
{
    public function testMin()
    {
        $this->assertEquals(is(-10), Math::min(is(-10), is(0)));
    }

    public function testMax()
    {        
        $this->assertEquals(is(0), Math::max(is(-10), is(0)));
    }
}
