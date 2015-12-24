<?php

namespace rezident\KladrJson\tests\row;



use rezident\KladrJson\row\Abbreviation;
use rezident\KladrJson\row\Name;

class NameTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \rezident\KladrJson\exceptions\EmptyNameException
     */
    public function testEmptyNameException()
    {
        new Name('', new Abbreviation('г'));
    }

    public function testToString()
    {
        $name = new Name('Пушкин', new Abbreviation('г'));
        $this->assertEquals('г. Пушкин', $name->__toString());
    }

    public function testGetAbbreviation()
    {
        $abbr = new Abbreviation('г');
        $name = new Name('Город', $abbr);
        $this->assertEquals($abbr, $name->getAbbreviation());
    }
}
