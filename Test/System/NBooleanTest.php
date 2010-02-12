<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__) . '/../../Olivine/Framework.php';

use \System\NBoolean;

import("System");

class NBooleanTest extends PHPUnit_Framework_TestCase
{

    public function testBooleanStrings()
    {
        $this->assertEquals("false", NBoolean::getFalseString()->stringValue());
        $this->assertEquals("true", NBoolean::getTrueString()->stringValue());
    }

    public function testConstructorWithBooleanArguments()
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

}