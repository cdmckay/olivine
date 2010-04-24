<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__) . '/../../Olivine/Framework.php';

use \System\NObject;
use \System\NException;

Olivine::import("System");

class NExceptionTest extends PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $e1 = new NException("test", 10);
        $this->assertEquals("test", $e1->getMessage()->string());
        $this->assertEquals(10, $e1->getCode()->int());

        $e2 = new NException(is("test"), is(10));
        $this->assertEquals("test", $e2->getMessage()->string());
        $this->assertEquals(is(10), $e2->getCode());
    }

    public function testAddMethod()
    {
        NException::addMethod("customFunc", function($e){
            return "poo";
        });

        $e = new NException();
        $this->assertEquals("poo", $e->customFunc());
    }
}
