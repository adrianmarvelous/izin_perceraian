<?php
$vendorDir = __DIR__ . '/vendor';
$baseDir = __DIR__;

$installed = json_decode(file_get_contents($vendorDir . '/composer/installed.json'), true);
$packages = $installed['packages'] ?? $installed;

// Generate autoload_files.php - with $vendorDir variable
$fileEntries = [];
foreach ($packages as $pkg) {
    if (!isset($pkg['autoload']['files'])) continue;
    foreach ($pkg['autoload']['files'] as $f) {
        $fileEntries[] = '$vendorDir . ' . var_export('/' . $pkg['name'] . '/' . $f, true);
    }
}

$out = "<?php\n\n// autoload_files.php @generated\n\n";
$out .= "\$vendorDir = dirname(__DIR__);\n";
$out .= "\$baseDir = dirname(\$vendorDir);\n\n";
$out .= "return array(\n";
foreach ($fileEntries as $i => $val) {
    $out .= "    " . $i . " => " . $val . ",\n";
}
$out .= ");\n";
file_put_contents($vendorDir . '/composer/autoload_files.php', $out);
echo "autoload_files.php written with " . count($fileEntries) . " files\n";

// Test
require $vendorDir . '/autoload.php';
echo "Laravel: " . (class_exists('Illuminate\\Foundation\\Application') ? 'OK' : 'FAIL') . "\n";
echo "PhpWord: " . (class_exists('PhpOffice\\PhpWord\\PhpWord') ? 'OK' : 'FAIL') . "\n";
