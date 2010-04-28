<?php

/*
 * (c) Copyright 2010 Cameron McKay
 *
 * This file is part of Olivine.
 * 
 * Olivine is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Olivine is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with Olivine.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__) . '/../../Olivine/Framework.php';

use \System\NFloat;

Olivine::import("System");
Olivine::useAliases();

class NFloatTest extends PHPUnit_Framework_TestCase
{
    const DELTA = 0.5;

    public function testConstructorUsingInt()
    {
        $val1 = NFloat::get(0);
        $val2 = NFloat::get(12);
        $val3 = NFloat::get(-12);

        $this->assertEquals(0, $val1->float());
        $this->assertEquals(12, $val2->float());
        $this->assertEquals(-12, $val3->float());
    }

    public function testConstructorUsingFloat()
    {
        $val1 = NFloat::get(0.0);
        $val2 = NFloat::get(12.12);
        $val3 = NFloat::get(-12.12);

        $this->assertEquals(0.0, $val1->float());
        $this->assertEquals(12.12, $val2->float());
        $this->assertEquals(-12.12, $val3->float());
    }

    public function testConstructorUsingNFloat()
    {
        $val1 = NFloat::get(0);
        $val2 = NFloat::get($val1);

        $this->assertEquals($val1, $val2);
    }

    public function testConstructorUsingNonNumeric()
    {
        $this->setExpectedException('System\ArgumentException');
        $val1 = NFloat::get("0");
    }  

    public function testAlias()
    {
        $val1 = NFloat::get(0.0);
        $val2 = NFloat::get(12.0);
        $val3 = NFloat::get(-12.0);

        $alias1 = is(0.0);
        $alias2 = is(12.0);
        $alias3 = is(-12.0);

        $this->assertEquals($val1->float(), $alias1->float());
        $this->assertEquals($val2->float(), $alias2->float());
        $this->assertEquals($val3->float(), $alias3->float());
    }

    public function testCompareTo()
    {
        $neg  = is(-12.0);
        $zero = is(0.0);
        $pos  = is(553.0);

        $this->assertLessThan(0, $neg->compareTo($zero)->int());
        $this->assertEquals(0, $zero->compareTo($zero)->int());
        $this->assertGreaterThan(0, $pos->compareTo($zero)->int());
    }

    public function testCompareToWithNull()
    {
        $num = is(42.0);
        $this->assertGreaterThan(0, $num->compareTo(null)->int());
    }

    public function testCompareToWithAutoBoxing()
    {
        $neg  = is(-12.0);
        $zero = is(0.0);
        $pos  = is(553.0);

        $this->assertLessThan(0, $neg->compareTo(0.0)->int());
        $this->assertEquals(0, $zero->compareTo(0.0)->int());
        $this->assertGreaterThan(0, $pos->compareTo(0.0)->int());
    }

    public function testEquals()
    {
        $int1 = is(10.5);
        $int2 = is(10.5);
        $int3 = is(11.0);

        $this->assertTrue( $int1->equals($int2)->bool() );
        $this->assertFalse( $int1->equals($int3)->bool() );
    }

    public function testEqualsWithAutoBoxing()
    {
        $int1 = is(10);
        $this->assertTrue( $int1->equals(10)->bool() );
        $this->assertFalse( $int1->equals(11)->bool() );
    }

    public function testEqualsWithNull()
    {
        $int = is(444);
        $this->assertFalse( $int->equals(null)->bool() );
    }

    public function testParse()
    {
        $this->assertTrue( is(0.0)->equals(NFloat::parse(is("0.0")))->bool() ) ;
        $this->assertTrue( is(-100.0)->equals(NFloat::parse(is("-100.0")))->bool() );
    }

    public function testParseWithAutoBoxing()
    {
        $this->assertTrue( is(0.0)->equals(NFloat::parse("0.0"))->bool() ) ;
        $this->assertTrue( is(-100.0)->equals(NFloat::parse("-100.0"))->bool() );
        $this->assertTrue( is(10.0)->equals(NFloat::parse("1e1"))->bool() );
    }

    public function testParseNull()
    {
        $this->setExpectedException('System\ArgumentNullException');
        NFloat::parse(null);
    }

    public function testParseWithInvalidFormat()
    {
        $this->setExpectedException('System\FormatException');
        NFloat::parse(is("I love lamp"));
    }

    public function testParseWithTooLargeFloat()
    {
        $this->setExpectedException('System\OverflowException');
        NFloat::parse("10e1000");
    }

    public function testTryParse()
    {
        $successful = NFloat::tryParse(is("10.0"), $result);
        $this->assertTrue(is(true)->equals($successful)->bool());
        $this->assertTrue(is(10.0)->equals($result)->bool());
    }

    public function testTryParseWithAutoBoxing()
    {
        $successful = NFloat::tryParse("10.0", $result);
        $this->assertTrue(is(true)->equals($successful)->bool());
        $this->assertTrue(is(10.0)->equals($result)->bool());
    }

    public function testTryParseWithInvalidFormat()
    {
        $successful = NFloat::tryParse(is("I hate lamp"), $result);
        $this->assertTrue(is(false)->equals($successful)->bool());
        $this->assertTrue(is(0.0)->equals($result)->bool());
    }    

    public function testNegate()
    {
        $val = is(1.0);
        $this->assertEquals(-1, $val->negate()->int());
    }

    public function testPlus()
    {
        $val1 = is(1.0);
        $val2 = is(2.0);
        $this->assertEquals(3.0, $val1->plus($val2)->int());
        $this->assertEquals(3.0, $val1->plus(2.0)->int());
    }

    public function testMinus()
    {
        $val1 = is(1.9);
        $val2 = is(2.9);
        $this->assertEquals(-1.0, $val1->minus($val2)->int());
        $this->assertEquals(-1.0, $val1->minus(2.9)->int());
    }

    public function testTimes()
    {
        $val1 = is(10.0);
        $val2 = is(2.0);
        $this->assertEquals(20.0, $val1->times($val2)->int());
        $this->assertEquals(20.0, $val1->times(2.0)->int());
    }

    public function testDivide()
    {
        $val1 = is(10.0);
        $val2 = is(2.0);
        $this->assertEquals(5.0, $val1->divide($val2)->int());
        $this->assertEquals(5.0, $val1->divide(2.0)->int());
    }

    public function testModulus()
    {
        $val1 = is(10.0);
        $val2 = is(3.0);
        $this->assertEquals(1.0, $val1->modulus($val2)->int());
        $this->assertEquals(1.0, $val1->modulus(3.0)->int());
    }

    public function testIsLessThan()
    {
        $val1 = is(5.4);
        $val2 = is(10.0);

        $this->assertFalse( $val1->isLessThan($val1)->bool() );
        $this->assertFalse( $val1->isLessThan(5.4)->bool() );

        $this->assertTrue(  $val1->isLessThan($val2)->bool() );
        $this->assertTrue(  $val1->isLessThan(10.0)->bool() );

        $this->assertFalse( $val2->isLessThan($val1)->bool() );
        $this->assertFalse( $val2->isLessThan(5.4)->bool() );
    }

    public function testIsLessThanOrEqualTo()
    {
        $val1 = is(5.0);
        $val2 = is(10.0);

        $this->assertTrue(  $val1->isLessThanOrEqualTo($val1)->bool() );
        $this->assertTrue(  $val1->isLessThanOrEqualTo(5.0)->bool() );

        $this->assertTrue(  $val1->isLessThanOrEqualTo($val2)->bool() );
        $this->assertTrue(  $val1->isLessThanOrEqualTo(10.0)->bool() );

        $this->assertFalse( $val2->isLessThanOrEqualTo($val1)->bool() );
        $this->assertFalse( $val2->isLessThanOrEqualTo(5.0)->bool() );
    }

    public function testIsGreaterThan()
    {
        $val1 = is(15.0);
        $val2 = is(5.0);

        $this->assertFalse( $val1->isGreaterThan($val1)->bool() );
        $this->assertFalse( $val1->isGreaterThan(15.0)->bool() );

        $this->assertTrue(  $val1->isGreaterThan($val2)->bool() );
        $this->assertTrue(  $val1->isGreaterThan(5.0)->bool() );

        $this->assertFalse( $val2->isGreaterThan($val1)->bool() );
        $this->assertFalse( $val2->isGreaterThan(15.0)->bool() );

        $this->assertTrue(  is(0.0)->isGreaterThan(is(-10.0))->bool() );
        $this->assertTrue(  is(0.0)->isGreaterThan(-10.0)->bool() );

        $this->assertFalse( is(-10.0)->isGreaterThan(is(0.0))->bool() );
        $this->assertFalse( is(-10.0)->isGreaterThan(0.0)->bool() );
    }

    public function testIsGreaterThanOrEqualTo()
    {
        $val1 = is(15.0);
        $val2 = is(5.0);

        $this->assertTrue(  $val1->isGreaterThanOrEqualTo($val1)->bool() );
        $this->assertTrue(  $val1->isGreaterThanOrEqualTo(15.0)->bool() );

        $this->assertTrue(  $val1->isGreaterThanOrEqualTo($val2)->bool() );
        $this->assertTrue(  $val1->isGreaterThanOrEqualTo(5.0)->bool() );

        $this->assertFalse( $val2->isGreaterThanOrEqualTo($val1)->bool() );
        $this->assertFalse( $val2->isGreaterThanOrEqualTo(15.0)->bool() );
    }

    public function testFloatOverflow()
    {
        $this->setExpectedException('System\OverflowException');
        is(1e308)->plus(1e308);
    }

    public function testNegativeFloatOverflow()
    {
        $this->setExpectedException('System\OverflowException');
        is(-1e308)->minus(1e308);
    }
}
