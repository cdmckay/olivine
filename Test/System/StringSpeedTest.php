<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <title>PHP string Speed Test</title>
    </head>
    <body>
<pre>
<?php

echo "Initial: " . memory_get_usage() . " bytes \n";

for ($i = 0; $i < 50000; $i++) {
    $array []= uniqid() . uniqid . uniqid() . uniqid;
}

echo "Final: " . memory_get_usage() . " bytes \n";
echo "Peak: " . memory_get_peak_usage() . " bytes \n";
?>
</pre>
    </body>
</html>

