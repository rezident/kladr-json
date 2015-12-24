<?php
namespace rezident\KladrJson\row;


use rezident\KladrJson\exceptions\EmptyNameException;

class Name
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var Abbreviation
     */
    private $abbr;

    /**
     * @param string $name
     * @param Abbreviation $abbr
     *
     * @throws EmptyNameException
     */
    public function __construct($name, Abbreviation $abbr)
    {
        if(empty($name)) {
            throw new EmptyNameException();
        }

        $this->abbr = $abbr;
        $this->name = $name;
    }

    public function __toString()
    {
        return $this->abbr->getWrappedName($this->name);
    }

    public function getAbbreviation()
    {
        return $this->abbr;
    }
}