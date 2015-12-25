<?php

namespace rezident\KladrJson\builder;


use rezident\KladrJson\row\Code;
use rezident\KladrJson\row\Name;

class Tree extends AbstractBuilder
{
    private $tree = [];

    public function buildPart(Name $name, Code $code) {
        echo $name->getName() . PHP_EOL;
    }
}