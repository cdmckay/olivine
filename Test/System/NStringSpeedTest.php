<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <title>Olivine NString Speed Test</title>
    </head>
    <body>
<pre>
<?php

require_once dirname(__FILE__) . '/../../Olivine/Framework.php';

use \System\NString;
Olivine::import("System");
Olivine::useAliases();

echo "Initial: " . memory_get_usage() . " bytes \n";

for ($i = 0; $i < 50000; $i++) {
    $array []= is(uniqid() . uniqid . uniqid() . uniqid);
}

echo "Final: " . memory_get_usage() . " bytes \n";
echo "Peak: " . memory_get_peak_usage() . " bytes \n";
?>
</pre>
    </body>
</html>

