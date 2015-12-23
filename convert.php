<?php

use rezident\KladrJson\Application;

require 'vendor/autoload.php';

try {
    (new Application())->run();
} catch(Exception $e) {
    $reflection = new ReflectionClass($e);
    echo ($reflection->getShortName() . ': ' . $e->getMessage()) . PHP_EOL;
}

