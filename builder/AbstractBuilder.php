<?php

namespace rezident\KladrJson\builder;


use rezident\KladrJson\row\Code;
use rezident\KladrJson\row\Name;

abstract class AbstractBuilder
{
    protected $data = [];

    public function getAsJson()
    {
        return json_encode($this->data, JSON_PRETTY_PRINT);
    }

    abstract public function buildPart(Name $name, Code $code);
}