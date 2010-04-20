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
        $this->assertEquals("false", NBoolean::getFalseString()->stringValue());
        $this->assertEquals("true", NBoolean::getTrueString()->stringValue());
    }

    public function testConstructor()
    {
        $false = is(false);
        $this->assertFalse($false->boolValue());

        $true = is(true);
        $this->assertTrue($true->boolValue());
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

        $this->assertEquals(-1, $false->compareTo($true)->intValue());
        $this->assertEquals(1, $true->compareTo($false)->intValue());
        $this->assertEquals(0, $false->compareTo($false)->intValue());
        $this->assertEquals(0, $true->compareTo($true)->intValue());
    }

    public function testCompareToWithAutoBoxing()
    {
        $true  = is(true);
        $false = is(false);

        $this->assertEquals(-1, $false->compareTo(true)->intValue());
        $this->assertEquals(1, $true->compareTo(false)->intValue());
        $this->assertEquals(0, $false->compareTo(false)->intValue());
        $this->assertEquals(0, $true->compareTo(true)->intValue());
    }

    public function testCompareToNull()
    {
        $false = is(false);
        $this->assertEquals(1, $false->compareTo(null)->intValue());
    }

    public function testGetHashCode()
    {
        $false = is(false);
        $true  = is(true);

        $this->assertEquals(0, $false->getHashCode()->intValue());
        $this->assertEquals(1, $true->getHashCode()->intValue());
    }

    public function testEquals()
    {
        $true1 = is(true);
        $true2 = is(true);
        $false = is(false);
        $this->assertTrue( $true1->equals($true2)->boolValue() );
        $this->assertFalse( $true1->equals($false)->boolValue() );
    }

    public function testEqualsWithAutoBoxing()
    {
        $true = is(true);       
        $this->assertTrue( $true->equals(true)->boolValue() );
        $this->assertFalse( $true->equals(false)->boolValue() );
    }

    public function testEqualsNull()
    {
        $true = is(true);
        $this->assertFalse( $true->equals(null)->boolValue() );
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

        $this->assertEquals(0, $val1->compareTo($true)->intValue());
        $this->assertEquals(0, $val2->compareTo($false)->intValue());
        $this->assertEquals(0, $val3->compareTo($true)->intValue());
        $this->assertEquals(0, $val4->compareTo($false)->intValue());
        $this->assertEquals(0, $val5->compareTo($true)->intValue());
        $this->assertEquals(0, $val6->compareTo($false)->intValue());
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

        $this->assertEquals(0, $val1->compareTo(true)->intValue());
        $this->assertEquals(0, $val2->compareTo(false)->intValue());        
    }    

    public function testToString()
    {
        $trueStr = is(true)->toString();
        $falseStr = is(false)->toString();

        $this->assertEquals("True", $trueStr->stringValue());
        $this->assertEquals("False", $falseStr->stringValue());
    }

    public function testTryParseWithValidNString()
    {
        $true  = is(true);
        $false = is(false);

        $successful = NBoolean::tryParse(is("true"), $result);
        $this->assertEquals(true, $successful->boolValue());
        $this->assertEquals(true, $result->boolValue());
    }

    public function testTryParseWithInvalidNString()
    {
        $true  = is(true);
        $false = is(false);

        $successful = NBoolean::tryParse(is("ture"), $result);
        $this->assertFalse($successful->boolValue());
        $this->assertFalse($result->boolValue());
    }

    public function testTryParseWithAutoBoxing()
    {
        $successful = NBoolean::tryParse("ture", $result);
        $this->assertFalse($successful->boolValue());
        $this->assertFalse($result->boolValue());
    }   

    public function testAndAlso()
    {
        $true  = is(true);
        $false = is(false);

        $this->assertEquals(true,  $true->andAlso($true)->boolValue());
        $this->assertEquals(false, $true->andAlso($false)->boolValue());
        $this->assertEquals(false, $false->andAlso($true)->boolValue());
        $this->assertEquals(false, $false->andAlso($false)->boolValue());
    }

    public function testAndAlsoWithShortCircuit()
    {
        $false = is(false);
        $this->assertEquals(false, $false->andAlso("monkey")->boolValue());
    }

    public function testAndAlsoWithAutoBoxing()
    {
        $true  = is(true);
        $false = is(false);

        $this->assertEquals(true,  $true->andAlso(true)->boolValue());
        $this->assertEquals(false, $true->andAlso(false)->boolValue());
        $this->assertEquals(false, $false->andAlso(true)->boolValue());
        $this->assertEquals(false, $false->andAlso(false)->boolValue());
    }

    public function testOrElse()
    {
        $true  = is(true);
        $false = is(false);

        $this->assertEquals(true,  $true->orElse($true)->boolValue());
        $this->assertEquals(true,  $true->orElse($false)->boolValue());
        $this->assertEquals(true,  $false->orElse($true)->boolValue());
        $this->assertEquals(false, $false->orElse($false)->boolValue());
    }

    public function testOrElseShortCircuit()
    {
        $true = is(true);
        $this->assertEquals(true, $true->orElse("monkey")->boolValue());
    }

    public function testOrElseWithAutoBoxing()
    {
        $true  = is(true);
        $false = is(false);

        $this->assertEquals(true,  $true->orElse(true)->boolValue());
        $this->assertEquals(true,  $true->orElse(false)->boolValue());
        $this->assertEquals(true,  $false->orElse(true)->boolValue());
        $this->assertEquals(false, $false->orElse(false)->boolValue());
    }
}