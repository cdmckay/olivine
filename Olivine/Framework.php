<?php

function import($namespace)
{
    // Replace all dots with forward slashes.
    $path = str_replace('.', '/', $namespace);
    $importer_path = dirname(__FILE__) . "/../$path/__Importer.php";
    require_once $importer_path;
    $importer = '\\' . str_replace('.', '\\', $namespace) . "\\__Importer";
    $importer::import();
}