<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__) . '/../../Olivine/Framework.php';

use \System\NBoolean;
use \System\NString;

Olivine::import("System");

class NStringTest extends PHPUnit_Framework_TestCase
{
    public function testGetEmpty()
    {
        $empty = is('');
        $this->assertEquals($empty, NString::getEmpty());
        $this->assertNotEquals("I love lamp", NString::getEmpty());
    }

    public function testConstructor()
    {
        $str1 = NString::get("one");
        $str2 = NString::get("two");
        $this->assertEquals("one", $str1->stringValue());
        $this->assertEquals("two", $str2->stringValue());
    }

    public function testConstructorWithNonString()
    {
        $this->setExpectedException('System\ArgumentException');
        NString::get(42);
    }

    public function testConcat()
    {
        $str = is('a');

        $ab = $str->concat(is('b'));
        $this->assertEquals('ab', $ab->stringValue());

        $abc = $str->concat(is('b'), is('c'));
        $this->assertEquals('abc', $abc->stringValue());

        $abcd = $str->concat(is('b'), is('c'), is('d'));
        $this->assertEquals('abcd', $abcd->stringValue());
    }

    public function testConcatWithNonStrings()
    {
        $str = is('foo');

        $foo4 = $str->concat(is(4));
        $this->assertEquals('foo4', $foo4->stringValue());
    }

    public function testStaticConcat()
    {
        $ab = NString::staticConcat(is('a'), is('b'));
        $this->assertEquals('ab', $ab->stringValue());

        $abc = NString::staticConcat(is('a'), is('b'), is('c'));
        $this->assertEquals('abc', $abc->stringValue());

        $abcd = NString::staticConcat(is('a'), is('b'), is('c'), is('d'));
        $this->assertEquals('abcd', $abcd->stringValue());
    }

    public function testStaticConcatWithNonStrings()
    {
        $bool = is(true);
        $num = is(4);

        $true4 = NString::staticConcat($bool, $num);
        $this->assertEquals('True4', $true4->stringValue());
    }

    

    public function testFormatWithString()
    {
        $str = is("test");
        $this->assertEquals(NString::format(is("%s"), $str), $str);
    }

    public function testFormatWithNumber()
    {
        $num = is(42);
        $this->assertEquals(NString::format(is("%d"), $num), is("42"));
    }
}
