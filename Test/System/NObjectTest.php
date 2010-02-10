<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__) . '/../../System/IObject.php';
require_once dirname(__FILE__) . '/../../System/NObject.php';

use \System\NObject;

class NObjectTest extends PHPUnit_Framework_TestCase
{
    public function testEquals()
    {
        $o1 = new NObject();
        $o2 = new NObject();
        $this->assertTrue($o1->equals($o1));
        $this->assertFalse($o1->equals($o2));
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
        $this->assertEquals("System\NObject", $o->getType());
        $this->assertNotEquals("System\NString", $o->getType());
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
        $this->assertEquals($o->getType(), $o->toString());
        $this->assertNotEquals("Foo", $o->toString());
    }

    public function testToStringMagicMethod()
    {
        $o = new NObject();
        $this->assertEquals($o->toString(), sprintf("%s", $o));
        $this->assertNotEquals("Foo", sprintf("%s", $o));
    }
    
}