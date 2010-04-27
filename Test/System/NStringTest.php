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
        $this->assertNotEquals("I love lamp", NString::getEmpty()->string());
    }

    public function testConstructor()
    {
        $str1 = NString::get("one");
        $str2 = NString::get("two");
        $this->assertEquals("one", $str1->string());
        $this->assertEquals("two", $str2->string());
    }

    public function testConstructorWithNonString()
    {
        $this->setExpectedException('System\ArgumentException');
        NString::get(42);
    }

    public function testCompare()
    {
        $this->assertEquals(0, NString::compare(is('a'), is('a'))->int());
        $this->assertGreaterThan(0, NString::compare(is('b'), is('a'))->int());
        $this->assertLessThan(0, NString::compare(is('a'), is('b'))->int());
    }

    public function testCompareWithAutoBoxing()
    {
        $this->assertEquals(0, NString::compare('a', 'a')->int());
        $this->assertGreaterThan(0, NString::compare('b', 'a')->int());
        $this->assertLessThan(0, NString::compare('a', 'b')->int());
    }

    public function testCompareWithIgnoreCase()
    {
        $this->assertNotEquals(0, NString::compare(is('a'), is('A'))->int());
        $this->assertEquals(0, NString::compare(is('a'), is('A'), is(true))->int());
    }

    public function testCompareWithIgnoreCaseAndAutoBoxing()
    {
        $this->assertNotEquals(0, NString::compare('a', 'A')->int());
        $this->assertEquals(0, NString::compare('a', 'A', true)->int());
    }

    public function testCompareTo()
    {
        $strA = is('a');
        $strB = is('b');

        $this->assertEquals(0, $strA->compareTo($strA)->int());
        $this->assertGreaterThan(0, $strB->compareTo($strA)->int());
        $this->assertLessThan(0, $strA->compareTo($strB)->int());
    }

    public function testCompareToWithAutoBoxing()
    {
        $strA = is('a');
        $strB = is('b');

        $this->assertEquals(0, $strA->compareTo('a')->int());
        $this->assertGreaterThan(0, $strB->compareTo('a')->int());
        $this->assertLessThan(0, $strA->compareTo('b')->int());
    }

    public function testConcat()
    {
        $str = is('a');

        $ab = $str->concat(is('b'));
        $this->assertEquals('ab', $ab->string());

        $abc = $str->concat(is('b'), is('c'));
        $this->assertEquals('abc', $abc->string());

        $abcd = $str->concat(is('b'), is('c'), is('d'));
        $this->assertEquals('abcd', $abcd->string());
    }

    public function testConcatWithAutoBoxing()
    {
        $str = is('a');

        $ab = $str->concat('b');
        $this->assertEquals('ab', $ab->string());

        $abc = $str->concat('b', 'c');
        $this->assertEquals('abc', $abc->string());

        $abcd = $str->concat('b', 'c', 'd');
        $this->assertEquals('abcd', $abcd->string());
    }

    public function testConcatWithNonStrings()
    {
        $str = is('foo');

        $t1 = $str->concat(is(4));
        $this->assertEquals('foo4', $t1->string());

        $t2 = $str->concat(1, 2, 3);
        $this->assertEquals('foo123', $t2->string());
        
        $t3 = $str->concat(true, 0.0);
        $this->assertEquals('foo10', $t3->string());
    }

    public function testConcatWithArrays()
    {
        $this->setExpectedException('System\ArgumentException');
        is("foo")->concat(array());
    }

    public function testConcatWithPHPObjects()
    {
        $this->setExpectedException('System\ArgumentException');
        is("foo")->concat(new stdClass());
    }

    public function testStaticConcat()
    {
        $ab = NString::staticConcat(is('a'), is('b'));
        $this->assertEquals('ab', $ab->string());

        $abc = NString::staticConcat(is('a'), is('b'), is('c'));
        $this->assertEquals('abc', $abc->string());

        $abcd = NString::staticConcat(is('a'), is('b'), is('c'), is('d'));
        $this->assertEquals('abcd', $abcd->string());
    }

    public function testStaticConcatWithNonStrings()
    {
        $bool = is(true);
        $num = is(4);

        $true4 = NString::staticConcat($bool, $num);
        $this->assertEquals('True4', $true4->string());
    }

    public function testContains()
    {
        $str = is("I am a big string: love me");

        $this->assertTrue(  $str->contains(is(""))->bool() );
        $this->assertTrue(  $str->contains(is("big"))->bool() );
        $this->assertTrue(  $str->contains(is("BIG"), is(true))->bool() );
        $this->assertFalse( $str->contains(is("BIG"))->bool() );
        $this->assertFalse( $str->contains(is("BIG"), is(false))->bool() );
        $this->assertFalse( $str->contains(is("small"))->bool() );
    }

    public function testContainsWithAutoBoxing()
    {
        $str = is("I am a big string: love me");

        $this->assertTrue(  $str->contains("")->bool() );
        $this->assertTrue(  $str->contains("big")->bool() );
        $this->assertTrue(  $str->contains("BIG", true)->bool() );
        $this->assertFalse( $str->contains("BIG")->bool() );
        $this->assertFalse( $str->contains("BIG", false)->bool() );
        $this->assertFalse( $str->contains("small")->bool() );
    }

    public function testContainsWithNull()
    {
        $this->setExpectedException('System\ArgumentNullException');
        is("foo")->contains(null);
    }    

    public function testEndsWith()
    {
        $str = is("superman");
        $this->assertTrue( $str->endsWith(is("man"))->bool() );
        $this->assertFalse( $str->endsWith(is("MAN"))->bool() );
        $this->assertTrue( $str->endsWith(NString::getEmpty())->bool() );
    }

    public function testEndsWithWithAutoBoxing()
    {
        $str = is("superman");
        $this->assertTrue( $str->endsWith("man")->bool() );
        $this->assertFalse( $str->endsWith("MAN")->bool() );
        $this->assertTrue( $str->endsWith(NString::getEmpty()->string())->bool() );
    }

    public function testEndsWithWithIgnoreCase()
    {
        $str = is("superman");
        $this->assertTrue( $str->endsWith(is("man"), is(true))->bool() );
        $this->assertTrue( $str->endsWith(is("MAN"), is(true))->bool() );
        $this->assertTrue( $str->endsWith(NString::getEmpty(), is(true))->bool() );
    }

    public function testEndsWithWithIgnoreCaseAndAutoBoxing()
    {
        $str = is("superman");
        $this->assertTrue( $str->endsWith("man", true)->bool() );
        $this->assertTrue( $str->endsWith("MAN", true)->bool() );
        $this->assertTrue( $str->endsWith(NString::getEmpty()->string(), true)->bool() );
    }

    public function testEquals()
    {
        $str1 = is("super");
        $str2 = is("super");
        $this->assertTrue( $str1->equals($str2)->bool() );
        $this->assertTrue( $str1->equals($str2->toUpper(), is(true))->bool() );
        $this->assertFalse( $str1->equals(is("foo"))->bool() );
        $this->assertFalse( $str1->equals(null)->bool() );
    }

    public function testEqualsWithAutoBoxing()
    {
        $str = is("super");        
        $this->assertTrue( $str->equals("super", true)->bool() );
        $this->assertTrue( $str->equals("SUPER", true)->bool() );
        $this->assertFalse( $str->equals("foo")->bool() );
    }

    public function testEqualsWithNonStrings()
    {
        $str = is("super");
        $this->assertFalse( $str->equals(22)->bool() );
        $this->assertFalse( is("22")->equals(22)->bool() );
        $this->assertFalse( $str->equals(new stdClass())->bool() );
    }

    public function testStaticEquals()
    {
        $str1 = is("super");
        $str2 = is("super");
        $this->assertTrue( NString::staticEquals($str1, $str2)->bool() );
        $this->assertFalse( NString::staticEquals($str1, is("foo"))->bool() );
        $this->assertFalse( NString::staticEquals($str1, null)->bool() );
    }

    public function testStaticEqualsWithNonStrings()
    {
        $this->setExpectedException('System\ArgumentException');
        NString::staticEquals(22, "22");
    }

    public function testFormatWithString()
    {
        $str = is("test");
        $this->assertEquals(NString::format(is("%s"), $str), $str);
        $this->assertEquals(NString::format(is("%s"), "test"), $str);
    }

    public function testFormatWithNumber()
    {
        $num = is(42);
        $this->assertEquals(NString::format(is("%d"), $num), is("42"));
        $this->assertEquals(NString::format(is("%d"), 42), is("42"));
    }

    public function testIndexOf()
    {
        $haystack = is("I am a long, long string");
        $needle = is("long");

        $this->assertEquals(is(7),  $haystack->indexOf($needle));
        $this->assertEquals(is(-1), $haystack->indexOf($needle, is(14)));
        $this->assertEquals(is(13), $haystack->indexOf($needle, is(8), is(10)));        
        $this->assertEquals(is(7),  $haystack->indexOf($needle, null, is(12)));
        $this->assertEquals(is(0),  $haystack->indexOf(NString::getEmpty()));
    }

    public function testIndexOfWithAutoBoxing()
    {
        $haystack = is("I am a long, long string");
        $needle = "long";

        $this->assertEquals(is(7),  $haystack->indexOf($needle));
        $this->assertEquals(is(-1), $haystack->indexOf($needle, 14));
        $this->assertEquals(is(13), $haystack->indexOf($needle, 8, 10));
        $this->assertEquals(is(7),  $haystack->indexOf($needle, null, 12));
        $this->assertEquals(is(0),  $haystack->indexOf(""));
    }

    public function testIndexOfWithIgnoreCase()
    {
        $haystack = is("I am a long, long string");
        $needle = is("LONG");

        $this->assertEquals(is(7),  $haystack->indexOf($needle, null, null, is(true)));
        $this->assertEquals(is(-1), $haystack->indexOf($needle, is(14), null, is(true)));
        $this->assertEquals(is(13), $haystack->indexOf($needle, is(8), is(10), is(true)));
        $this->assertEquals(is(7),  $haystack->indexOf($needle, null, is(12), is(true)));
        $this->assertEquals(is(0),  $haystack->indexOf(NString::getEmpty(), null, null, is(true)));
    }

    public function testIndexOfWithIgnoreCaseAndAutoBoxing()
    {
        $haystack = is("I am a long, long string");
        $needle = "LONG";

        $this->assertEquals(is(7),  $haystack->indexOf($needle, null, null, true));
        $this->assertEquals(is(-1), $haystack->indexOf($needle, 14, null, true));
        $this->assertEquals(is(13), $haystack->indexOf($needle, 8, 10, true));
        $this->assertEquals(is(7),  $haystack->indexOf($needle, null, 12, true));
        $this->assertEquals(is(0),  $haystack->indexOf("", null, null, true));
    }

    public function testIndexOfWithNegativeStartIndex()
    {
        $this->setExpectedException('System\ArgumentOutOfRangeException');
        is("poop")->indexOf(is("op"), is(-1));
    }

    public function testIndexOfWithNegativeCount()
    {
        $this->setExpectedException('System\ArgumentOutOfRangeException');
        is("poop")->indexOf(is("op"), is(0), is(-1));
    }

    public function testIndexOfWithStartIndexPlusCountGreaterThanLength()
    {
        $this->setExpectedException('System\ArgumentOutOfRangeException');
        is("poop")->indexOf(is("op"), is(0), is(1000));
    }

    public function testInsert()
    {
        $str = is("supermanisdead");
        $this->assertEquals(is("supermanisnotdead"), $str->insert(is(10), is("not")));
        $this->assertEquals(is("supermanisdeader"), $str->insert($str->getLength(), is("er")));
    }

    public function testInsertWithAutoBoxing()
    {
        $str = is("supermanisdead");
        $this->assertEquals(is("supermanisnotdead"), $str->insert(10, "not"));
        $this->assertEquals(is("supermanisdeader"), $str->insert($str->getLength()->int(), "er"));
    }

    public function testInsertWithNull()
    {
        $this->setExpectedException('System\ArgumentNullException');
        is("foo")->insert(is(0), null);
    }

    public function testInsertWithNegativeStartIndex()
    {
        $this->setExpectedException('System\ArgumentOutOfRangeException');
        is("foo")->insert(is(-20), is("bar"));
    }

    public function testInsertWithStartIndexGreaterThanLength()
    {
        $this->setExpectedException('System\ArgumentOutOfRangeException');
        $str = is("foo");
        $str->insert($str->getLength()->plus(is(1)), is("bar"));
    }

    public function testLastIndexOf()
    {
        $haystack = is("I am a long, long string");
        $needle = is("long");        

        $this->assertEquals(is(13), $haystack->lastIndexOf($needle));
        $this->assertEquals(is(7),  $haystack->lastIndexOf($needle, is(13)));
        $this->assertEquals(is(7),  $haystack->lastIndexOf($needle, is(12), is(12)));
        $this->assertEquals(is(13), $haystack->lastIndexOf($needle, null,  is(12)));

        $this->assertEquals($haystack->getLength(), $haystack->lastIndexOf(NString::getEmpty()));
        $this->assertEquals(is(4), $haystack->lastIndexOf(NString::getEmpty(), is(4)));
        $this->assertEquals(is(10), $haystack->lastIndexOf(NString::getEmpty(), is(10), is(6)));
    }

    public function testLastIndexOfWithIgnoreCase()
    {
        $haystack = is("I am a long, long string");
        $needle = is("LONG");

        $this->assertEquals(is(13), $haystack->lastIndexOf($needle, null, null, is(true)));
        $this->assertEquals(is(7),  $haystack->lastIndexOf($needle, is(13), null, is(true)));
        $this->assertEquals(is(7),  $haystack->lastIndexOf($needle, is(12), is(12), is(true)));
        $this->assertEquals(is(13), $haystack->lastIndexOf($needle, null,  is(12), is(true)));

        $this->assertEquals($haystack->getLength(), $haystack->lastIndexOf(NString::getEmpty(), null, null, is(true)));
        $this->assertEquals(is(4), $haystack->lastIndexOf(NString::getEmpty(), is(4), null, is(true)));
        $this->assertEquals(is(10), $haystack->lastIndexOf(NString::getEmpty(), is(10), is(6), is(true)));
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

    public function testReplace()
    {
        $str1 = _string("superman");
        $this->assertEquals(is("supergirl"), $str1->replace(is("man"), is("girl")));
        $this->assertEquals(is("super"), $str1->replace(is("man"), null));
        $this->assertEquals(is("super"), $str1->replace(is("man"), NString::getEmpty()));

        $str2 = _string("Superman is the man!");
        $this->assertEquals(is("Supergirl is the girl!"), $str2->replace(is("man"), is("girl")));
    }

    public function testReplaceWithOldValueAsNull()
    {
        $this->setExpectedException('System\ArgumentNullException');
        _string("foo")->replace(null, is("bar"));
    }

    public function testReplaceWithOldValueAsEmptyString()
    {
        $this->setExpectedException('System\ArgumentException');
        _string("foo")->replace(NString::getEmpty(), is("bar"));
    }

    public function testSubstring()
    {
        $str = is("superman");
        $this->assertEquals(is("man"),           $str->substring(is(5)));
        $this->assertEquals(is("super"),         $str->substring(is(0), is(5)));        
        $this->assertEquals(NString::getEmpty(), $str->substring(is(5), is(0)));
        $this->assertEquals(NString::getEmpty(), $str->substring($str->getLength()));
    }

    public function testSubstringWithStartIndexPlusLengthGreaterThanLength()
    {
        $this->setExpectedException('System\ArgumentOutOfRangeException');
        $this->assertEquals(is("superman"), is("superman")->substring(is(0), is(1000000)));
    }
}
