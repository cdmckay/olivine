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

use \System\NBool;
use \System\NString;

Olivine::import("System");

class NBoolTest extends PHPUnit_Framework_TestCase
{
    public function testBooleanStrings()
    {
        $this->assertEquals("false", NBool::getFalseString()->string());
        $this->assertEquals("true", NBool::getTrueString()->string());
    }

    public function testConstructor()
    {
        $false = is(false);
        $this->assertFalse($false->bool());

        $true = is(true);
        $this->assertTrue($true->bool());
    }

    public function testConstructorWithNull()
    {
        $this->setExpectedException('System\ArgumentException');
        is(null);
    }

    public function testPrimitiveFunction()
    {
        $this->assertTrue( NBool::primitive(true) );
        $this->assertFalse( NBool::primitive(false) );
        $this->assertTrue( NBool::primitive(is(true)) );
        $this->assertFalse( NBool::primitive(is(false)) );
    }

    public function testCompareTo()
    {
        $true  = is(true);
        $false = is(false);

        $this->assertEquals(-1, $false->compareTo($true)->int());
        $this->assertEquals(1, $true->compareTo($false)->int());
        $this->assertEquals(0, $false->compareTo($false)->int());
        $this->assertEquals(0, $true->compareTo($true)->int());
    }

    public function testCompareToWithAutoBoxing()
    {
        $true  = is(true);
        $false = is(false);

        $this->assertEquals(-1, $false->compareTo(true)->int());
        $this->assertEquals(1, $true->compareTo(false)->int());
        $this->assertEquals(0, $false->compareTo(false)->int());
        $this->assertEquals(0, $true->compareTo(true)->int());
    }

    public function testCompareToNull()
    {
        $false = is(false);
        $this->assertEquals(1, $false->compareTo(null)->int());
    }

    public function testGetHashCode()
    {
        $false = is(false);
        $true  = is(true);

        $this->assertEquals(0, $false->getHashCode()->int());
        $this->assertEquals(1, $true->getHashCode()->int());
    }

    public function testEquals()
    {
        $true1 = is(true);
        $true2 = is(true);
        $false = is(false);
        $this->assertTrue( $true1->equals($true2)->bool() );
        $this->assertFalse( $true1->equals($false)->bool() );
    }

    public function testEqualsWithAutoBoxing()
    {
        $true = is(true);       
        $this->assertTrue( $true->equals(true)->bool() );
        $this->assertFalse( $true->equals(false)->bool() );
    }

    public function testEqualsNull()
    {
        $true = is(true);
        $this->assertFalse( $true->equals(null)->bool() );
    }

    public function testParseWithValidNStrings()
    {
        $true  = is(true);
        $false = is(false);

        $val1 = NBool::parse(is("true"));
        $val2 = NBool::parse(is("false"));
        $val3 = NBool::parse(is(" true "));
        $val4 = NBool::parse(is(" false "));
        $val5 = NBool::parse(is("TRUE"));
        $val6 = NBool::parse(is("FALSE"));

        $this->assertEquals(0, $val1->compareTo($true)->int());
        $this->assertEquals(0, $val2->compareTo($false)->int());
        $this->assertEquals(0, $val3->compareTo($true)->int());
        $this->assertEquals(0, $val4->compareTo($false)->int());
        $this->assertEquals(0, $val5->compareTo($true)->int());
        $this->assertEquals(0, $val6->compareTo($false)->int());
    }

    public function testParseWithInvalidNString()
    {
        $this->setExpectedException('System\FormatException');
        NBool::parse(is("ture"));
    }

    public function testParseWithAutoBoxing()
    {               
        $val1 = NBool::parse("true");
        $val2 = NBool::parse("false");

        $this->assertEquals(0, $val1->compareTo(true)->int());
        $this->assertEquals(0, $val2->compareTo(false)->int());        
    }    

    public function testToString()
    {
        $trueStr = is(true)->toString();
        $falseStr = is(false)->toString();

        $this->assertEquals("True", $trueStr->string());
        $this->assertEquals("False", $falseStr->string());
    }

    public function testTryParseWithValidNString()
    {
        $true  = is(true);
        $false = is(false);

        $successful = NBool::tryParse(is("true"), $result);
        $this->assertEquals(true, $successful->bool());
        $this->assertEquals(true, $result->bool());
    }

    public function testTryParseWithInvalidNString()
    {
        $true  = is(true);
        $false = is(false);

        $successful = NBool::tryParse(is("ture"), $result);
        $this->assertFalse($successful->bool());
        $this->assertFalse($result->bool());
    }

    public function testTryParseWithAutoBoxing()
    {
        $successful = NBool::tryParse("ture", $result);
        $this->assertFalse($successful->bool());
        $this->assertFalse($result->bool());
    }   

    public function testAndAlso()
    {
        $true  = is(true);
        $false = is(false);

        $this->assertEquals(true,  $true->andAlso($true)->bool());
        $this->assertEquals(false, $true->andAlso($false)->bool());
        $this->assertEquals(false, $false->andAlso($true)->bool());
        $this->assertEquals(false, $false->andAlso($false)->bool());
    }

    public function testAndAlsoWithShortCircuit()
    {
        $false = is(false);
        $this->assertEquals(false, $false->andAlso("monkey")->bool());
    }

    public function testAndAlsoWithAutoBoxing()
    {
        $true  = is(true);
        $false = is(false);

        $this->assertEquals(true,  $true->andAlso(true)->bool());
        $this->assertEquals(false, $true->andAlso(false)->bool());
        $this->assertEquals(false, $false->andAlso(true)->bool());
        $this->assertEquals(false, $false->andAlso(false)->bool());
    }

    public function testOrElse()
    {
        $true  = is(true);
        $false = is(false);

        $this->assertEquals(true,  $true->orElse($true)->bool());
        $this->assertEquals(true,  $true->orElse($false)->bool());
        $this->assertEquals(true,  $false->orElse($true)->bool());
        $this->assertEquals(false, $false->orElse($false)->bool());
    }

    public function testOrElseShortCircuit()
    {
        $true = is(true);
        $this->assertEquals(true, $true->orElse("monkey")->bool());
    }

    public function testOrElseWithAutoBoxing()
    {
        $true  = is(true);
        $false = is(false);

        $this->assertEquals(true,  $true->orElse(true)->bool());
        $this->assertEquals(true,  $true->orElse(false)->bool());
        $this->assertEquals(true,  $false->orElse(true)->bool());
        $this->assertEquals(false, $false->orElse(false)->bool());
    }
}