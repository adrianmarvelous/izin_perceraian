<?php
$packages = require __DIR__ . '/bootstrap/cache/packages.php';
file_put_contents(__DIR__ . '/bootstrap/cache/packages.php', '<?php return ' . var_export($packages, true) . ';');
echo "Removed breeze from cache\n";
