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
        $this->assertNotEquals("I love lamp", NString::getEmpty()->stringValue());
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

    public function testCompare()
    {
        $this->assertEquals(0, NString::compare(is('a'), is('a'))->intValue());
        $this->assertGreaterThan(0, NString::compare(is('b'), is('a'))->intValue());
        $this->assertLessThan(0, NString::compare(is('a'), is('b'))->intValue());
    }

    public function testCompareWithIgnoreCase()
    {
        $this->assertNotEquals(0, NString::compare(is('a'), is('A'))->intValue());
        $this->assertEquals(0, NString::compare(is('a'), is('A'), is(true))->intValue());
    }

    public function testCompareWithNull()
    {
        $this->assertEquals(0, NString::compare(null, null)->intValue());
        $this->assertGreaterThan(0, NString::compare(is('b'), null)->intValue());
        $this->assertLessThan(0, NString::compare(null, is('b'))->intValue());
    }

    public function testCompareTo()
    {
        $strA = is('a');
        $strB = is('b');

        $this->assertEquals(0, $strA->compareTo($strA)->intValue());
        $this->assertGreaterThan(0, $strB->compareTo($strA)->intValue());
        $this->assertLessThan(0, $strA->compareTo($strB)->intValue());
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

    public function testContains()
    {
        $str = is("I am a big string: love me");

        $this->assertTrue(  $str->contains(is(""))->boolValue() );
        $this->assertTrue(  $str->contains(is("big"))->boolValue() );
        $this->assertTrue(  $str->contains(is("BIG"), is(true))->boolValue() );
        $this->assertFalse( $str->contains(is("BIG"))->boolValue() );
        $this->assertFalse( $str->contains(is("BIG"), is(false))->boolValue() );
        $this->assertFalse( $str->contains(is("small"))->boolValue() );
    }

    public function testContainsWithNull()
    {
        $this->setExpectedException('System\ArgumentNullException');
        is("test")->contains(null);
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

    public function testSubstring()
    {
        $str = is("superman");
        $this->assertEquals(is("man"), $str->substring(is(5)));
        $this->assertEquals(is("super"), $str->substring(is(0), is(5)));
        $this->assertEquals(is("superman"), $str->substring(is(0), is(1000)));
        $this->assertEquals(NString::getEmpty(), $str->substring(is(5), is(0)));
    }
}
