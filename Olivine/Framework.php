<?php

final class Olivine
{    
    public static function import($namespace)
    {
        // Replace all dots with forward slashes.
        $path = str_replace('.', '/', $namespace);
        $importer_path = dirname(__FILE__) . "/../$path/.OlivineInfo.php";
        require_once $importer_path;
        $importer = '\\' . str_replace('.', '\\', $namespace) . "\\OlivineInfo";
        $importer::import();
    }

    public static function useAliases()
    {
        require_once dirname(__FILE__) . "/Aliases.php";
    }

}

