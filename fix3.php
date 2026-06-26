<?php
$vendorDir = __DIR__ . '/vendor';
$baseDir = __DIR__;

$installed = json_decode(file_get_contents($vendorDir . '/composer/installed.json'), true);
$packages = $installed['packages'] ?? $installed;

// Generate autoload_files.php
$files = [];
foreach ($packages as $pkg) {
    if (!isset($pkg['autoload']['files'])) continue;
    $installPath = $vendorDir . '/' . $pkg['name'];
    foreach ($pkg['autoload']['files'] as $f) {
        $fullPath = $installPath . '/' . $f;
        $fullPath = str_replace('\\', '/', $fullPath);
        $key = crc32($fullPath);
        $files[$key] = '$vendorDir . ' . var_export('/' . $pkg['name'] . '/' . $f, true);
    }
}

$out = "<?php\n\n// autoload_files.php @generated\n\n";
$out .= "return array(\n";
foreach ($files as $key => $val) {
    $out .= "    " . $key . " => " . $val . ",\n";
}
$out .= ");\n";
file_put_contents($vendorDir . '/composer/autoload_files.php', $out);
echo "autoload_files.php written with " . count($files) . " files\n";

// Test
require $vendorDir . '/autoload.php';
echo "Laravel: " . (class_exists('Illuminate\\Foundation\\Application') ? 'OK' : 'FAIL') . "\n";
echo "PhpWord: " . (class_exists('PhpOffice\\PhpWord\\PhpWord') ? 'OK' : 'FAIL') . "\n";
