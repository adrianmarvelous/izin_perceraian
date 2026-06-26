<?php
require __DIR__ . '/vendor/autoload.php';
$psr4 = require __DIR__ . '/vendor/composer/autoload_psr4.php';
echo 'PhpOffice\PhpWord: ' . (isset($psr4['PhpOffice\\PhpWord\\']) ? 'SET at ' . implode(',', $psr4['PhpOffice\\PhpWord\\']) : 'NOT SET') . "\n";
echo 'Illuminate: ' . (isset($psr4['Illuminate\\']) ? 'SET' : 'NOT SET') . "\n";
echo 'Total: ' . count($psr4) . " entries\n";

// Check what's in autoload.php
echo "\nAutoload files:\n";
$files = require __DIR__ . '/vendor/composer/autoload_files.php';
echo 'Files count: ' . count($files) . "\n";

// Try to require PhpWord directly
echo "\nManual require test:\n";
require __DIR__ . '/vendor/phpoffice/phpword/src/PhpWord/Autoloader.php';
\PhpOffice\PhpWord\Autoloader::register();
echo 'After manual register - PhpWord: ' . (class_exists('PhpOffice\\PhpWord\\PhpWord') ? 'OK' : 'FAIL') . "\n";
echo 'After manual register - Laravel: ' . (class_exists('Illuminate\\Foundation\\Application') ? 'OK' : 'FAIL') . "\n";
