<?php

/*
 * (c) Copyright 2010 Cameron McKay
 *
 * This file is part of Olivine.
 *
 * Olivine is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Olivine is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with Olivine.  If not, see <http://www.gnu.org/licenses/>.
 */

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
