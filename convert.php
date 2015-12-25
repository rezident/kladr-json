<?php

use rezident\KladrJson\Application;
use rezident\KladrJson\builder\Tree;
use rezident\KladrJson\filter\AndCollection;
use rezident\KladrJson\filter\Level;
use rezident\KladrJson\filter\Status;

require 'vendor/autoload.php';

$filter = new AndCollection([
    new Status(),
    new Level([0, 1])
]);
$builder = new Tree();

try {
    (new Application())->run($filter, $builder);
} catch(Exception $e) {
    $reflection = new ReflectionClass($e);
    echo ($reflection->getShortName() . ': ' . $e->getMessage()) . PHP_EOL;
}

