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

    public function testEndsWith()
    {
        $str = is("superman");
        $this->assertTrue( $str->endsWith(is("man"))->boolValue() );
        $this->assertFalse( $str->endsWith(is("MAN"))->boolValue() );
        $this->assertTrue( $str->endsWith(NString::getEmpty())->boolValue() );
    }

    public function testEndsWithWithIgnoreCase()
    {
        $str = is("superman");
        $this->assertTrue( $str->endsWith(is("man"), is(true))->boolValue() );
        $this->assertTrue( $str->endsWith(is("MAN"), is(true))->boolValue() );
        $this->assertTrue( $str->endsWith(NString::getEmpty(), is(true))->boolValue() );
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

    public function testLastIndexOf()
    {
        $haystack = is("I am a long, long string");
        $needle = is("long");        

        $this->assertEquals(is(13), $haystack->lastIndexOf($needle));
        $this->assertEquals(is(-1), $haystack->lastIndexOf($needle, is(14)));
        $this->assertEquals(is(7),  $haystack->lastIndexOf($needle, is(0), is(12)));
        $this->assertEquals(is(7),  $haystack->lastIndexOf($needle, null,  is(12)));
        
        $this->assertEquals($haystack->getLength(), $haystack->lastIndexOf(NString::getEmpty()));
    }

    public function testLastIndexOfWithIgnoreCase()
    {
        $haystack = is("I am a long, long string");
        $needle = is("LONG");

        $this->assertEquals(is(13), $haystack->lastIndexOf($needle, null,   null,   is(true)));
        $this->assertEquals(is(-1), $haystack->lastIndexOf($needle, is(14), null,   is(true)));
        $this->assertEquals(is(7),  $haystack->lastIndexOf($needle, is(0),  is(12), is(true)));
        $this->assertEquals(is(7),  $haystack->lastIndexOf($needle, null,   is(12), is(true)));
    }

    public function testLastIndexOfWithNull()
    {
        $this->setExpectedException('System\ArgumentNullException');
        $this->assertEquals(is(13), is("poop")->lastIndexOf(null));
    }

    public function testLastIndexOfWithNegativeStartIndex()
    {
        $this->setExpectedException('System\ArgumentOutOfRangeException');
        $this->assertEquals(is(13), is("poop")->lastIndexOf(is("op"), is(-1)));
    }

    public function testLastIndexOfWithNegativeCount()
    {
        $this->setExpectedException('System\ArgumentOutOfRangeException');
        $this->assertEquals(is(13), is("poop")->lastIndexOf(is("op"), is(0), is(-1)));
    }

    public function testSubstring()
    {
        $str = is("superman");
        $this->assertEquals(is("man"),           $str->substring(is(5)));
        $this->assertEquals(is("super"),         $str->substring(is(0), is(5)));
        $this->assertEquals(is("superman"),      $str->substring(is(0), is(1000)));
        $this->assertEquals(NString::getEmpty(), $str->substring(is(5), is(0)));        
    }

    public function testSubstringWithHugeLength()
    {
        $this->setExpectedException('System\OverflowException');
        $this->assertEquals(is("superman"), is("superman")->substring(is(0), _number("10e10")));
    }
}
