<?php

namespace rezident\KladrJson\row;


use rezident\KladrJson\exceptions\UnknownAbbrException;

class Abbreviation
{
    /**
     * @var string
     */
    private $prefix;

    /**
     * @var string
     */
    private $suffix;

    private $map = [
        'г'         => ['г.',   ''],
        'р-н'       => ['',     'район']
    ];

    public function __construct($abbr)
    {
        if(isset($this->map[$abbr]) == false) {
            throw new UnknownAbbrException($abbr);
        }

        $this->prefix = $this->map[$abbr][0];
        $this->suffix = $this->map[$abbr][1];
    }

    public function getWrappedName($name)
    {
        $name = ' ' . trim($name) . ' ';
        return trim($this->prefix . $name . $this->suffix);
    }
}