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
        $false = NBoolean::get(false);
        $this->assertFalse($false->boolValue());

        $true = NBoolean::get(true);
        $this->assertTrue($true->boolValue());
    }       

    public function testCompareTo()
    {
        $true  = NBoolean::get(true);
        $false = NBoolean::get(false);

        $this->assertEquals(-1, $false->compareTo($true)->intValue());
        $this->assertEquals(1, $true->compareTo($false)->intValue());
        $this->assertEquals(0, $false->compareTo($false)->intValue());
        $this->assertEquals(0, $true->compareTo($true)->intValue());
    }

    public function testCompareToNull()
    {
        $false = NBoolean::get(false);
        $this->assertEquals(1, $false->compareTo(null)->intValue());
    }

    public function testGetHashCode()
    {
        $false = NBoolean::get(false);
        $true  = NBoolean::get(true);

        $this->assertEquals(0, $false->getHashCode()->intValue());
        $this->assertEquals(1, $true->getHashCode()->intValue());
    }

    public function testEquals()
    {
        $true1 = NBoolean::get(true);
        $true2 = NBoolean::get(true);
        $false = NBoolean::get(false);
        $this->assertTrue( $true1->equals($true2)->boolValue() );
        $this->assertFalse( $true1->equals($false)->boolValue() );
    }

    public function testEqualsNull()
    {
        $true = NBoolean::get(true);
        $this->assertFalse( $true->equals(null)->boolValue() );
    }

    public function testParseWithValidNStrings()
    {
        $true  = NBoolean::get(true);
        $false = NBoolean::get(false);

        $val1 = NBoolean::parse(NString::get("true"));
        $val2 = NBoolean::parse(NString::get("false"));
        $val3 = NBoolean::parse(NString::get(" true "));
        $val4 = NBoolean::parse(NString::get(" false "));
        $val5 = NBoolean::parse(NString::get("TRUE"));
        $val6 = NBoolean::parse(NString::get("FALSE"));

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
        NBoolean::parse(NString::get("ture"));
    }   

    public function testToString()
    {
        $trueStr = NBoolean::get(true)->toString();
        $falseStr = NBoolean::get(false)->toString();

        $this->assertEquals("True", $trueStr->stringValue());
        $this->assertEquals("False", $falseStr->stringValue());
    }

    public function testTryParseWithValidNString()
    {
        $true  = NBoolean::get(true);
        $false = NBoolean::get(false);

        $successful = NBoolean::tryParse(NString::get("true"), $result);
        $this->assertEquals(true, $successful->boolValue());
        $this->assertEquals(true, $result->boolValue());
    }

    public function testTryParseWithInvalidNString()
    {
        $true  = NBoolean::get(true);
        $false = NBoolean::get(false);

        $successful = NBoolean::tryParse(NString::get("ture"), $result);
        $this->assertEquals(false, $successful->boolValue());
        $this->assertEquals(false, $result->boolValue());
    }

}