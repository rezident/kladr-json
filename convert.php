<?php

use rezident\KladrJson\Application;
use rezident\KladrJson\builder\Tree;
use rezident\KladrJson\filter\Abbreviation;
use rezident\KladrJson\filter\AndCollection;
use rezident\KladrJson\filter\Level;
use rezident\KladrJson\filter\Status;

require 'vendor/autoload.php';

$abbrFilter = new Abbreviation();
$abbrFilter->not([
    'снт',
    'дп',
    'тер',
    'нп',
    'рзд',
    'казарма',
    'мкр',
    'промзона',
    'ж/д_будка',
    'п/ст',
    'ж/д_оп',
    'кв-л',
    'ж/д_рзд',
    'ж/д_ст',
    'городок',
    'автодорога',
    'п/о',
    'с/мо',
    'ж/д_казарм',
    'массив',
    'ж/д_платф',
    'ж/д_пост',
    'погост',
    'жилзона',
    'п/р',
    'ш',
    'км',
    'днп',
    'лпх',
    'округ',
    'ул',
]);
Tree::$merged = [
    47 => 78,    // Санкт-Петербург и Ленинградская область
    50 => 77,    // Москва и Московская область
    91 => 92     // Севастополь и Республика Крым
];

$filter = new AndCollection([
    new Status(),
    new Level(0),
    $abbrFilter
]);
$builder = new Tree();

try {
    (new Application())->run($filter, $builder);
} catch(Exception $e) {
    $reflection = new ReflectionClass($e);
    echo ($reflection->getShortName() . ': ' . $e->getMessage()) . PHP_EOL;
}

