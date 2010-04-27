<?php

namespace System;

final class OlivineInfo
{
    private static $tree = array(        
        "IObject" => array(
            "NObject" => array(                
                "NBoolean" => array(),                                
                "NInt" => array(),
                "NFloat" => array(),
                "NString" => array(),
                "Console" => array(),
                "Environment" => array(),
                "Math" => array()
            ),
            "NException" => array(
                "SystemException" => array(
                    "ArithmeticException" => array(
                        "OverflowException" => array()
                    ),
                    "ArgumentException" => array(
                        "ArgumentNullException" => array(),
                        "ArgumentOutOfRangeException" => array()
                    ),
                    "FormatException" => array(),
                    "InvalidCastException" => array(),
                    'MemberAccessException' => array(
                        'MissingMemberException' => array(
                            'MissingMethodException' => array()
                        )
                    ),
                    "NotImplementedException" => array()
                )
            )
        ),
        "INumber" => array(),
        "ICloneable" => array(),
        "IComparable" => array(),
        "IConvertible" => array(),
        "IEnumerable" => array(),        
        "IFormattable" => array()                
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
