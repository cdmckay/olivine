<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__) . '/../../Olivine/Framework.php';

use \System\NInteger;

Olivine::import("System");
Olivine::useAliases();

class NIntegerTest extends PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $val1 = new NInteger(0);
        $val2 = new NInteger(12);
        $val3 = new NInteger(-12);

        $this->assertEquals(0, $val1->intValue());
        $this->assertEquals(12, $val2->intValue());
        $this->assertEquals(-12, $val3->intValue());
    }

    public function testAlias()
    {
        $val1 = new NInteger(0);
        $val2 = new NInteger(12);
        $val3 = new NInteger(-12);

        $alias1 = __(0);
        $alias2 = __(12);
        $alias3 = __(-12);

        $this->assertEquals($val1->intValue(), $alias1->intValue());
        $this->assertEquals($val2->intValue(), $alias2->intValue());
        $this->assertEquals($val3->intValue(), $alias3->intValue());
    }

    public function testCompareTo()
    {
        
    }

}
