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
        $this->name = trim($name);
        if(empty($this->name)) {
            throw new EmptyNameException();
        }

        $this->abbr = $abbr;
    }

    public function __toString()
    {
        return $this->abbr->getWrappedName($this->name);
    }

    public function getAbbreviation()
    {
        return $this->abbr;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

}