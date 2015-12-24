<?php

namespace rezident\KladrJson\filter;


use rezident\KladrJson\row\Code;
use rezident\KladrJson\row\Name;

class Negative implements InterfaceFilter
{

    /**
     * @var InterfaceFilter
     */
    private $filter;

    public function __construct(InterfaceFilter $filter)
    {
        $this->filter = $filter;
    }

    public function isAllowed(Name $name, Code $code)
    {
        return !$this->filter->isAllowed($name, $code);
    }

}