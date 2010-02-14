<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__) . '/../../Olivine/Framework.php';

use \System\NBoolean;
use \System\NString;

import("System");

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

    public function testGetHashCode()
    {
        $false = NBoolean::get(false);
        $true  = NBoolean::get(true);

        $this->assertEquals(0, $false->getHashCode()->intValue());
        $this->assertEquals(1, $true->getHashCode()->intValue());
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

    public function testParseWithValidNStrings()
    {
        $true  = NBoolean::get(true);
        $false = NBoolean::get(false);

        $val1 = NBoolean::parse(new NString("true"));
        $val2 = NBoolean::parse(new NString("false"));
        $val3 = NBoolean::parse(new NString(" true "));
        $val4 = NBoolean::parse(new NString(" false "));

        $this->assertEquals(0, $val1->compareTo($true)->intValue());
        $this->assertEquals(0, $val2->compareTo($false)->intValue());
        $this->assertEquals(0, $val3->compareTo($true)->intValue());
        $this->assertEquals(0, $val4->compareTo($false)->intValue());
    }

    public function testParseWithInvalidNString()
    {
        $this->setExpectedException('System\FormatException');
        NBoolean::parse(new NString("ture"));
    }

    public function testParseWithInvalidArgument()
    {
        $this->setExpectedException('System\ArgumentException');
        NBoolean::parse("true");
    }

    public function testParseWithNullArgument()
    {
        $this->setExpectedException('System\ArgumentNullException');      
        NBoolean::parse(null);
    }   

}