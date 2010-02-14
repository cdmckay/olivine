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
        $val1 = NInteger::get(0);
        $val2 = NInteger::get(12);
        $val3 = NInteger::get(-12);

        $this->assertEquals(0, $val1->intValue());
        $this->assertEquals(12, $val2->intValue());
        $this->assertEquals(-12, $val3->intValue());
    }

    public function testAlias()
    {
        $val1 = NInteger::get(0);
        $val2 = NInteger::get(12);
        $val3 = NInteger::get(-12);

        $alias1 = is(0);
        $alias2 = is(12);
        $alias3 = is(-12);

        $this->assertEquals($val1->intValue(), $alias1->intValue());
        $this->assertEquals($val2->intValue(), $alias2->intValue());
        $this->assertEquals($val3->intValue(), $alias3->intValue());
    }

    public function testCompareTo()
    {
        $neg  = is(-12);
        $zero = is(0);
        $pos  = is(553);

        $this->assertLessThan(0, $neg->compareTo($zero)->intValue());
        $this->assertEquals(0, $zero->compareTo($zero)->intValue());
        $this->assertGreaterThan(0, $pos->compareTo($zero)->intValue());
    }

    public function testCompareToNull()
    {
        $num = is(42);
        $this->assertGreaterThan(0, $num->compareTo(null)->intValue());
    }

    public function testEquals()
    {
        $int1 = is(10);
        $int2 = is(10);
        $int3 = is(11);

        $this->assertTrue( $int1->equals($int2)->boolValue() );
        $this->assertFalse( $int1->equals($int3)->boolValue() );
    }

    public function testEqualsNull()
    {
        $int = is(444);
        $this->assertFalse( $int->equals(null)->boolValue() );
    }

}
