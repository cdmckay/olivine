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

namespace System;

interface INumber
{
    public function isLessThan($value);
    public function isLessThanOrEqualTo($value);
    public function isGreaterThan($value);
    public function isGreaterThanOrEqualTo($value);
    public function divide($value);
    public function times($value);
    public function plus($value);
    public function minus($value);
    public function modulus($value);
}