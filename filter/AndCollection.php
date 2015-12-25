<?php

namespace rezident\KladrJson\filter;


use rezident\KladrJson\row\Code;
use rezident\KladrJson\row\Name;

class AndCollection extends CollectionAbstract
{

    /**
     * @param Name $name
     * @param Code $code
     *
     * @return bool
     */
    public function isAllowed(Name $name, Code $code)
    {
        foreach($this->filters as $filter) {
            if($filter->isAllowed($name, $code) == false) {
                return false;
            }

        }

        return true;
    }
}