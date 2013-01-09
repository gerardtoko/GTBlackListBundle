<?php



error_reporting(E_ALL);

$file = __DIR__.'/../vendor/autoload.php';
if (!file_exists($file)) {
    throw new RuntimeException('Install dependencies to run test suite.');
}

$loader = require_once $file;
$loader->add('GT\BlackListBundle', __DIR__);
