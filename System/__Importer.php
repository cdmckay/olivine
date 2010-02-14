<?php

namespace System;

final class __Importer
{
    private static $tree = array(
        "IObject" => array(
            "NObject" => array(
                "NBoolean" => array(),
                "NFloat" => array(),
                "NInteger" => array(),
                "NString" => array(),
            ),
            "NException" => array(
                "SystemException" => array(
                    "ArgumentException" => array(
                        "ArgumentNullException" => array()
                    ),
                    "FormatException" => array(),
                    "InvalidCastException" => array()
                )
            )
        ),
        "ICloneable" => array(),
        "IComparable" => array(),
        "IConvertible" => array(),
        "IEnumerable" => array(),
        "IEquatable" => array(),
        "IFormattable" => array(),
    );

    public static function import()
    {
        self::importRecursive(self::$tree);
    }

    private static function importRecursive($array)
    {
        $queue = array();

        foreach($array as $key => $value)
        {
            require_once dirname(__FILE__) . "/$key.php";
            if (count($value) > 0)
                array_push($queue, $value);
        }

        foreach($queue as $node)
            self::importRecursive($node);
    }

}
