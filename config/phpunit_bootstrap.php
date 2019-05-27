<?php

include_once __DIR__ . '/../vendor/autoload.php';

$classLoader = new \Composer\Autoload\ClassLoader();
$classLoader->addPsr4("LeoVie\\PhpNamespaceValidator\\Tests\\", __DIR__ . '/../src/Tests', true);
$classLoader->register();