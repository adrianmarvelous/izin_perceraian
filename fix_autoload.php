<?php
$vendorDir = __DIR__ . '/vendor';
$baseDir = __DIR__;

$installed = json_decode(file_get_contents($vendorDir . '/composer/installed.json'), true);
$packages = $installed['packages'] ?? $installed;

$psr4 = [];

// Project entries
$psr4['App\\'] = [$baseDir . '/app'];
$psr4['Database\\Seeders\\'] = [$baseDir . '/database/seeders'];
$psr4['Database\\Factories\\'] = [$baseDir . '/database/factories'];
$psr4['Tests\\'] = [$baseDir . '/tests'];

// From packages
foreach ($packages as $pkg) {
    if (!isset($pkg['autoload']['psr-4'])) continue;
    $installPath = $vendorDir . '/' . $pkg['name'];
    foreach ($pkg['autoload']['psr-4'] as $namespace => $dirs) {
        $dirs = (array)$dirs;
        foreach ($dirs as $dir) {
            $fullPath = $installPath . '/' . $dir;
            $psr4[$namespace][] = $fullPath;
        }
    }
}

// Write file
$out = "<?php\n\n// autoload_psr4.php @generated\n\n";
$out .= "\$vendorDir = dirname(__DIR__);\n";
$out .= "\$baseDir = dirname(\$vendorDir);\n\n";
$out .= "return array(\n";
ksort($psr4);
foreach ($psr4 as $ns => $dirs) {
    $paths = [];
    foreach ($dirs as $d) {
        $d = str_replace('\\', '/', $d);
        $d = str_replace($vendorDir, '\$vendorDir', $d);
        $d = str_replace($baseDir, '\$baseDir', $d);
        $paths[] = "'" . $d . "'";
    }
    $out .= "    '" . addslashes($ns) . "' => array(" . implode(', ', $paths) . "),\n";
}
$out .= ");\n";

file_put_contents($vendorDir . '/composer/autoload_psr4.php', $out);
echo "Written " . count($psr4) . " entries\n";

require $vendorDir . '/autoload.php';
echo "Laravel: " . (class_exists('Illuminate\\Foundation\\Application') ? 'OK' : 'FAIL') . "\n";
echo "PhpWord: " . (class_exists('PhpOffice\\PhpWord\\PhpWord') ? 'OK' : 'FAIL') . "\n";
