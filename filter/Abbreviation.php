<?php

namespace rezident\KladrJson\filter;


use rezident\KladrJson\row\Code;
use rezident\KladrJson\row\Name;

class Abbreviation implements InterfaceFilter
{
    /**
     * @var string[]
     */
    private $only;

    /**
     * @var string[]
     */
    private $not;

    public function isAllowed(Name $name, Code $code)
    {
        if(is_array($this->only)) {
            if(in_array($name->getAbbreviation()->getAbbr(), $this->only) == false) {
                return false;
            }
        }

        if(is_array($this->not)) {
            if(in_array($name->getAbbreviation()->getAbbr(), $this->not)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string[] $abbreviations
     */
    public function only(array $abbreviations)
    {
        $this->only = $abbreviations;
    }

    /**
     * @param string[] $abbreviations
     */
    public function not(array $abbreviations)
    {
        $this->not = $abbreviations;
    }
}