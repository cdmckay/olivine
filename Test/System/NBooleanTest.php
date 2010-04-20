<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__) . '/../../Olivine/Framework.php';

use \System\NBoolean;
use \System\NString;

Olivine::import("System");

class NBooleanTest extends PHPUnit_Framework_TestCase
{
    public function testBooleanStrings()
    {
        $this->assertEquals("false", NBoolean::getFalseString()->string());
        $this->assertEquals("true", NBoolean::getTrueString()->string());
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

        $val1 = NBoolean::parse(is("true"));
        $val2 = NBoolean::parse(is("false"));
        $val3 = NBoolean::parse(is(" true "));
        $val4 = NBoolean::parse(is(" false "));
        $val5 = NBoolean::parse(is("TRUE"));
        $val6 = NBoolean::parse(is("FALSE"));

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
        NBoolean::parse(is("ture"));
    }

    public function testParseWithAutoBoxing()
    {               
        $val1 = NBoolean::parse("true");
        $val2 = NBoolean::parse("false");

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

        $successful = NBoolean::tryParse(is("true"), $result);
        $this->assertEquals(true, $successful->bool());
        $this->assertEquals(true, $result->bool());
    }

    public function testTryParseWithInvalidNString()
    {
        $true  = is(true);
        $false = is(false);

        $successful = NBoolean::tryParse(is("ture"), $result);
        $this->assertFalse($successful->bool());
        $this->assertFalse($result->bool());
    }

    public function testTryParseWithAutoBoxing()
    {
        $successful = NBoolean::tryParse("ture", $result);
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