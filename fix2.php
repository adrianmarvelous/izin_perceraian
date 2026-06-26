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
        $files[] = $installPath . '/' . $f;
    }
}

$out = "<?php\n\n// autoload_files.php @generated\n\n";
$out .= "return array(\n";
foreach ($files as $i => $f) {
    $f = str_replace('\\', '/', $f);
    $f = str_replace($vendorDir, "\$vendorDir", $f);
    $out .= "    " . $i . " => " . $f . ",\n";
}
$out .= ");\n";
file_put_contents($vendorDir . '/composer/autoload_files.php', $out);
echo "autoload_files.php written with " . count($files) . " entries\n";

// Test
require $vendorDir . '/autoload.php';
echo "Laravel: " . (class_exists('Illuminate\\Foundation\\Application') ? 'OK' : 'FAIL') . "\n";
echo "PhpWord: " . (class_exists('PhpOffice\\PhpWord\\PhpWord') ? 'OK' : 'FAIL') . "\n";
