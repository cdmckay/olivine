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

use \System\NInt;

Olivine::import("System");
Olivine::useAliases();

class NIntTest extends PHPUnit_Framework_TestCase
{
    const DELTA = 0.5;

    public function testConstructorUsingInt()
    {
        $val1 = NInt::get(0);
        $val2 = NInt::get(12);
        $val3 = NInt::get(-12);

        $this->assertEquals(0, $val1->int());
        $this->assertEquals(12, $val2->int());
        $this->assertEquals(-12, $val3->int());
    }    

    public function testConstructorUsingNInt()
    {
        $val1 = NInt::get(0);
        $val2 = NInt::get($val1);

        $this->assertEquals($val1, $val2);
    }

    public function testConstructorUsingNonInt()
    {
        $this->setExpectedException('System\ArgumentException');
        $val1 = NInt::get(0.0);       
    }  

    public function testAlias()
    {
        $val1 = NInt::get(0);
        $val2 = NInt::get(12);
        $val3 = NInt::get(-12);

        $alias1 = is(0);
        $alias2 = is(12);
        $alias3 = is(-12);

        $this->assertEquals($val1->int(), $alias1->int());
        $this->assertEquals($val2->int(), $alias2->int());
        $this->assertEquals($val3->int(), $alias3->int());
    }

    public function testCompareTo()
    {
        $neg  = is(-12);
        $zero = is(0);
        $pos  = is(553);

        $this->assertLessThan(0, $neg->compareTo($zero)->int());
        $this->assertEquals(0, $zero->compareTo($zero)->int());
        $this->assertGreaterThan(0, $pos->compareTo($zero)->int());
    }

    public function testCompareToWithNull()
    {
        $num = is(42);
        $this->assertGreaterThan(0, $num->compareTo(null)->int());
    }

    public function testCompareToWithAutoBoxing()
    {
        $neg  = is(-12);
        $zero = is(0);
        $pos  = is(553);

        $this->assertLessThan(0, $neg->compareTo(0)->int());
        $this->assertEquals(0, $zero->compareTo(0)->int());
        $this->assertGreaterThan(0, $pos->compareTo(0)->int());
    }

    public function testEquals()
    {
        $int1 = is(10);
        $int2 = is(10);
        $int3 = is(11);

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
        $this->assertTrue( is(0)->equals(NInt::parse(is("0")))->bool() ) ;
        $this->assertTrue( is(-100)->equals(NInt::parse(is("-100")))->bool() );        
    }

    public function testParseWithAutoBoxing()
    {
        $this->assertTrue( is(0)->equals(NInt::parse("0"))->bool() ) ;
        $this->assertTrue( is(-100)->equals(NInt::parse("-100"))->bool() );
    }

    public function testParseNull()
    {
        $this->setExpectedException('System\ArgumentNullException');
        NInt::parse(null);
    }

    public function testParseWithInvalidFormat()
    {
        $this->setExpectedException('System\FormatException');
        NInt::parse(is("I love lamp"));
    }

    public function testParseWithTooLargeInt()
    {
        $this->setExpectedException('System\OverflowException');
        NInt::parse((string) (PHP_INT_MAX + 1));
    }

    public function testParseWithTooSmallInt()
    {
        $this->setExpectedException('System\OverflowException');
        NInt::parse((string) (-PHP_INT_MAX - 2));
    }

    public function testTryParse()
    {
        $successful = NInt::tryParse(is("10"), $result);
        $this->assertTrue(is(true)->equals($successful)->bool());
        $this->assertTrue(is(10)->equals($result)->bool());
    }

    public function testTryParseWithAutoBoxing()
    {
        $successful = NInt::tryParse("10", $result);
        $this->assertTrue(is(true)->equals($successful)->bool());
        $this->assertTrue(is(10)->equals($result)->bool());
    }

    public function testTryParseWithInvalidFormat()
    {
        $successful = NInt::tryParse(is("I hate lamp"), $result);
        $this->assertTrue(is(false)->equals($successful)->bool());
        $this->assertTrue(is(0)->equals($result)->bool());
    }    

    public function testNegate()
    {
        $val = is(1);
        $this->assertEquals(-1, $val->negate()->int());
    }

    public function testPlus()
    {
        $val1 = is(1);
        $val2 = is(2);
        $this->assertEquals(3, $val1->plus($val2)->int());
        $this->assertEquals(3, $val1->plus(2)->int());
    }

    public function testMinus()
    {
        $val1 = is(1);
        $val2 = is(2);
        $this->assertEquals(-1, $val1->minus($val2)->int());
        $this->assertEquals(-1, $val1->minus(2)->int());
    }

    public function testTimes()
    {
        $val1 = is(10);
        $val2 = is(2);
        $this->assertEquals(20, $val1->times($val2)->int());
        $this->assertEquals(20, $val1->times(2)->int());
    }

    public function testDivide()
    {
        $val1 = is(10);
        $val2 = is(2);
        $this->assertEquals(5, $val1->divide($val2)->int());
        $this->assertEquals(5, $val1->divide(2)->int());
    }

    public function testModulus()
    {
        $val1 = is(10);
        $val2 = is(3);
        $this->assertEquals(1, $val1->modulus($val2)->int());
        $this->assertEquals(1, $val1->modulus(3)->int());
    }

    public function testIsLessThan()
    {
        $val1 = is(5);
        $val2 = is(10);

        $this->assertFalse( $val1->isLessThan($val1)->bool() );
        $this->assertFalse( $val1->isLessThan(5)->bool() );

        $this->assertTrue(  $val1->isLessThan($val2)->bool() );
        $this->assertTrue(  $val1->isLessThan(10)->bool() );

        $this->assertFalse( $val2->isLessThan($val1)->bool() );
        $this->assertFalse( $val2->isLessThan(5)->bool() );
    }

    public function testIsLessThanOrEqualTo()
    {
        $val1 = is(5);
        $val2 = is(10);

        $this->assertTrue(  $val1->isLessThanOrEqualTo($val1)->bool() );
        $this->assertTrue(  $val1->isLessThanOrEqualTo(5)->bool() );

        $this->assertTrue(  $val1->isLessThanOrEqualTo($val2)->bool() );
        $this->assertTrue(  $val1->isLessThanOrEqualTo(10)->bool() );

        $this->assertFalse( $val2->isLessThanOrEqualTo($val1)->bool() );
        $this->assertFalse( $val2->isLessThanOrEqualTo(5)->bool() );
    }

    public function testIsGreaterThan()
    {
        $val1 = is(15);
        $val2 = is(5);

        $this->assertFalse( $val1->isGreaterThan($val1)->bool() );
        $this->assertFalse( $val1->isGreaterThan(15)->bool() );

        $this->assertTrue(  $val1->isGreaterThan($val2)->bool() );
        $this->assertTrue(  $val1->isGreaterThan(5)->bool() );

        $this->assertFalse( $val2->isGreaterThan($val1)->bool() );
        $this->assertFalse( $val2->isGreaterThan(15)->bool() );

        $this->assertTrue(  is(0)->isGreaterThan(is(-10))->bool() );
        $this->assertTrue(  is(0)->isGreaterThan(-10)->bool() );

        $this->assertFalse( is(-10)->isGreaterThan(is(0))->bool() );
        $this->assertFalse( is(-10)->isGreaterThan(0)->bool() );
    }

    public function testIsGreaterThanOrEqualTo()
    {
        $val1 = is(15);
        $val2 = is(5);

        $this->assertTrue(  $val1->isGreaterThanOrEqualTo($val1)->bool() );
        $this->assertTrue(  $val1->isGreaterThanOrEqualTo(15)->bool() );

        $this->assertTrue(  $val1->isGreaterThanOrEqualTo($val2)->bool() );
        $this->assertTrue(  $val1->isGreaterThanOrEqualTo(5)->bool() );

        $this->assertFalse( $val2->isGreaterThanOrEqualTo($val1)->bool() );
        $this->assertFalse( $val2->isGreaterThanOrEqualTo(15)->bool() );
    }

    public function testIntOverflow()
    {
        $this->setExpectedException('System\OverflowException');
        is(PHP_INT_MAX)->plus(1);
    }

    public function testNegativeIntOverflow()
    {
        $this->setExpectedException('System\OverflowException');
        is(-PHP_INT_MAX)->minus(2);
    }
}
