<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__) . '/../../Olivine/Framework.php';

use \System\NObject;
use \System\NString;

Olivine::import("System");

class NObjectTest extends PHPUnit_Framework_TestCase
{
    public function testEquals()
    {
        $o1 = new NObject();
        $o2 = new NObject();
        $this->assertTrue($o1->equals($o1)->bool());
        $this->assertFalse($o1->equals($o2)->bool());
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
        $this->assertEquals("System\NObject", $o->getType()->string());
        $this->assertNotEquals("System\NString", $o->getType()->string());
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
        $this->assertEquals($o->getType()->string(), $o->toString()->string());
        $this->assertNotEquals("Foo", $o->toString()->string());
    }

    public function testToStringMagicMethod()
    {
        $o = new NObject();
        $this->assertEquals($o->__toString(), sprintf("%s", $o));
        $this->assertNotEquals("Foo", sprintf("%s", $o));
    }

    public function testAddMethod()
    {
        NString::addMethod("customFunc", function($str){
            return strtoupper($str->string());
        });

        $this->assertEquals("STR", NString::get("str")->customFunc());
    }

    public function testAddMethodWithInheritance()
    {
        NObject::addMethod("testFunc", function($object){
            return get_class($object);
        });

        $this->assertEquals("System\NString", NString::get("str")->testFunc());
    }
}