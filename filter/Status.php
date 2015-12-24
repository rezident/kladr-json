<?php

namespace rezident\KladrJson\filter;


use rezident\KladrJson\row\Code;
use rezident\KladrJson\row\Name;

class Status implements InterfaceFilter
{
    public function isAllowed(Name $name, Code $code)
    {
        return $code->isAvailable();
    }

}