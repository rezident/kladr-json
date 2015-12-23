<?php

namespace rezident\KladrJson\tests\row;


use rezident\KladrJson\row\Abbreviation;

class AbbreviationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \rezident\KladrJson\exceptions\UnknownAbbrException
     */
    public function testCreateWithUnknownAbbr()
    {
        new Abbreviation('unknown');
    }

    public function testCityAbbr()
    {
        $abbr = new Abbreviation('г');
        $this->assertEquals('г. Пушкин', $abbr->getWrappedName('Пушкин'));
    }

    public function testDistrictAbbr()
    {
        $abbr = new Abbreviation('р-н');
        $this->assertEquals('Пушкинский район', $abbr->getWrappedName(' Пушкинский '));
    }
}
