<?php

namespace rezident\KladrJson\filter;


use rezident\KladrJson\row\Code;
use rezident\KladrJson\row\Name;

class CodeFilter implements InterfaceFilter
{

    /**
     * @var array
     */
    private $options;

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public function isAllowed(Name $name, Code $code)
    {
        if(isset($this->options['region']) && $code->region != $this->options['region']) {
            return false;
        }

        if(isset($this->options['district']) && $code->district != $this->options['district']) {
            return false;
        }

        if(isset($this->options['city']) && $code->city != $this->options['city']) {
            return false;
        }

        if(isset($this->options['locality']) && $code->locality != $this->options['locality']) {
            return false;
        }

        return true;

    }
}