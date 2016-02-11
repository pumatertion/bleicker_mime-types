<?php

use Composer\Autoload\ClassLoader;

if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
    throw new \RuntimeException('Could not find vendor/autoload.php, make sure you ran composer.');
}

/**
 * @param ClassLoader $autoloader
 */
$boot = function (ClassLoader $autoloader) {
};

$boot(require __DIR__ . '/../vendor/autoload.php');
unset($boot);
