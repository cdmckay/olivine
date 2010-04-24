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
        $e1 = new NException("test");
        $this->assertEquals("test", $e1->getMessage()->string());

        $e2 = new NException(is("test"));
        $this->assertEquals("test", $e2->getMessage()->string());
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
