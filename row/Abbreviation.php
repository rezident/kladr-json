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

    /**
     * @var string
     */
    private $abbr;

    static public $map = [
        'г'         => ['г.',   ''],
        'р-н'       => ['',     'район']
    ];

    public function __construct($abbr)
    {
        if(isset(self::$map[$abbr]) == false) {
            throw new UnknownAbbrException($abbr);
        }

        $this->prefix = self::$map[$abbr][0];
        $this->suffix = self::$map[$abbr][1];
        $this->abbr = $abbr;
    }

    public function getWrappedName($name)
    {
        $name = ' ' . trim($name) . ' ';
        return trim($this->prefix . $name . $this->suffix);
    }

    /**
     * @return string
     */
    public function getAbbr()
    {
        return $this->abbr;
    }


}