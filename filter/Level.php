<?php

namespace rezident\KladrJson\filter;


use rezident\KladrJson\row\Code;
use rezident\KladrJson\row\Name;

class Level implements InterfaceFilter
{

    private $max;

    private $min;

    public function __construct($level)
    {
        if(is_array($level)) {
            if(isset($level[0])) {
                $this->min = $level[0];
            }

            if(isset($level[1])) {
                $this->max = $level[1];
            }
        } else {
            $this->min = $this->max = $level;
        }

    }

    public function isAllowed(Name $name, Code $code)
    {
        return !(
            (isset($this->min) && $code->getLevel() < $this->min) ||
            (isset($this->max) && $code->getLevel() > $this->max)
        );
    }
}