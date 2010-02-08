<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__) . '/../../System/IComparable.php';
require_once dirname(__FILE__) . '/../../System/IConvertible.php';
require_once dirname(__FILE__) . '/../../System/NObject.php';
require_once dirname(__FILE__) . '/../../System/NBoolean.php';
require_once dirname(__FILE__) . '/../../System/NInteger.php';

use \System\NBoolean;

class NBooleanTest extends PHPUnit_Framework_TestCase
{

    public function testBooleanStrings()
    {
        $this->assertEquals("false", NBoolean::FALSE_STRING);
        $this->assertEquals("true", NBoolean::TRUE_STRING);
    }

    public function testConstructorWithBooleanArguments()
    {
        $boolFalse = new NBoolean(false);
        $this->assertFalse($boolFalse->toNativeBoolean());

        $boolTrue = new NBoolean(true);
        $this->assertTrue($boolTrue->toNativeBoolean());
    }

    public function testConstructorWithIntegerArguments()
    {
        $boolZero = new NBoolean(0);
        $this->assertFalse($boolZero->toNativeBoolean());

        $boolOne = new NBoolean(1);
        $this->assertTrue($boolOne->toNativeBoolean());

        $boolNegative = new NBoolean(-1);
        $this->assertTrue($boolNegative->toNativeBoolean());
    }

    public function testGetHashCode()
    {
        $false = new NBoolean(false);
        $true  = new NBoolean(true);

        $this->assertEquals(0, $false->getHashCode()->toNativeInteger());
        $this->assertEquals(1, $true->getHashCode()->toNativeInteger());
    }

}