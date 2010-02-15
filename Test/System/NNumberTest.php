<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__) . '/../../Olivine/Framework.php';

use \System\NNumber;

Olivine::import("System");
Olivine::useAliases();

class NNumberTest extends PHPUnit_Framework_TestCase
{
    const DELTA = 0.05;

    public function testConstructorUsingInt()
    {
        $val1 = NNumber::get(0);
        $val2 = NNumber::get(12);
        $val3 = NNumber::get(-12);

        $this->assertEquals(0, $val1->intValue());
        $this->assertEquals(12, $val2->intValue());
        $this->assertEquals(-12, $val3->intValue());
    }

    public function testConstructorUsingFloat()
    {
        $val1 = NNumber::get(0.0);
        $val2 = NNumber::get(12.12);
        $val3 = NNumber::get(-12.12);

        $this->assertEquals(0.0, $val1->floatValue(), '', self::DELTA);
        $this->assertEquals(12.12, $val2->floatValue(), '', self::DELTA);
        $this->assertEquals(-12.12, $val3->floatValue(), '', self::DELTA);
    }

    public function testConstructorUsingString()
    {
        $val1 = NNumber::get("0");
        $val2 = NNumber::get("0.0");
        $val3 = NNumber::get("-12.12");
        $val4 = NNumber::get("12e12");

        $this->assertEquals(0, $val1->intValue());
        $this->assertEquals(0.0, $val2->floatValue(), '', self::DELTA);
        $this->assertEquals(-12.12, $val3->floatValue(), '', self::DELTA);       
        $this->assertEquals(12e12, $val4->floatValue(), '', self::DELTA);
    }

    public function testAlias()
    {
        $val1 = NNumber::get(0);
        $val2 = NNumber::get(12);
        $val3 = NNumber::get(-12);
        $val4 = NNUmber::get("12e12");

        $alias1 = is(0);
        $alias2 = is(12);
        $alias3 = is(-12);
        $alias4 = _num("12e12");

        $this->assertEquals($val1->intValue(), $alias1->intValue());
        $this->assertEquals($val2->intValue(), $alias2->intValue());
        $this->assertEquals($val3->intValue(), $alias3->intValue());
        $this->assertEquals($val4->floatValue(), $alias4->floatValue());
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

    public function testPlus()
    {
        $val1 = is(1);
        $val2 = is(2);
        $this->assertEquals(3, $val1->plus($val2)->intValue());
    }   

    public function testMinus()
    {
        $val1 = is(1);
        $val2 = is(2);
        $this->assertEquals(-1, $val1->minus($val2)->intValue());
    }

    public function testTimes()
    {
        $val1 = is(10);
        $val2 = is(2);
        $this->assertEquals(20, $val1->times($val2)->intValue());
    }

    public function testDivide()
    {
        $val1 = is(10);
        $val2 = is(2);
        $this->assertEquals(5, $val1->divide($val2)->intValue());
    }

    public function testModulus()
    {
        $val1 = is(10);
        $val2 = is(3);
        $this->assertEquals(1, $val1->modulus($val2)->intValue());
    }   

    public function testIntValueOverflow()
    {
        $this->setExpectedException('System\OverflowException');

        $val1 = is(PHP_INT_MAX);
        $val2 = is(PHP_INT_MAX);
        $val1->plus($val2)->intValue();
    }

    public function testIntValueUnderflow()
    {
        $this->setExpectedException('System\OverflowException');

        $val1 = is(-10);
        $val2 = is(PHP_INT_MAX);
        $val1->minus($val2)->intValue();
    }

    public function testFloatValueOverflow()
    {
        $this->setExpectedException('System\OverflowException');
        
        $val = is(2);
        while (true)
        {
            $val = $val->times($val);
            $val->floatValue();
        }
    }

//    public function testFloatValueUnderflow()
//    {
//        $this->setExpectedException('System\OverflowException');
//
//        $val = is(2);
//        $foo = is(2);
//        while (true)
//        {
//            $val = $val->divide($foo);
//            echo $val->floatValue() . "\n";
//        }
//    }

}
