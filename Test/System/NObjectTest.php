<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__) . '/../../Olivine/Framework.php';

use \System\NObject;

Olivine::import("System");

class NObjectTest extends PHPUnit_Framework_TestCase
{
    public function testEquals()
    {
        $o1 = new NObject();
        $o2 = new NObject();
        $this->assertTrue($o1->equals($o1)->boolValue());
        $this->assertFalse($o1->equals($o2)->boolValue());
    }

    public function testGetHashCode()
    {
        $o1 = new NObject();
        $o2 = new NObject();
        $this->assertEquals($o1->getHashCode(), $o1->getHashCode());
        $this->assertNotEquals($o1->getHashCode(), $o2->getHashCode());
    }

    public function testGetType()
    {
        $o = new NObject();
        $this->assertEquals("System\NObject", $o->getType()->stringValue());
        $this->assertNotEquals("System\NString", $o->getType()->stringValue());
    }

    public function testMemberwiseClone()
    {
        $o1 = new NObject();
        $o2 = $o1->memberwiseClone();
        $this->assertTrue($o1 == $o2);
        $this->assertFalse($o1 === $o2);
    }

    public function testToString()
    {
        $o = new NObject();
        $this->assertEquals($o->getType()->stringValue(), $o->toString()->stringValue());
        $this->assertNotEquals("Foo", $o->toString()->stringValue());
    }

    public function testToStringMagicMethod()
    {
        $o = new NObject();
        $this->assertEquals($o->__toString(), sprintf("%s", $o));
        $this->assertNotEquals("Foo", sprintf("%s", $o));
    }
    
}