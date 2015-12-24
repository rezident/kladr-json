<?php

namespace rezident\KladrJson\tests\filter;


use rezident\KladrJson\filter\Abbreviation;
use rezident\KladrJson\row\Code;
use rezident\KladrJson\row\Name;

class AbbreviationTest extends \PHPUnit_Framework_TestCase
{
    public function testAllowCity()
    {
        $filter = new Abbreviation();
        $filter->only(['г']);
        $code = new Code('7877632487908');
        $name = new Name('город', new \rezident\KladrJson\row\Abbreviation('г'));
        $this->assertTrue($filter->isAllowed($name, $code));

        $name = new Name('город', new \rezident\KladrJson\row\Abbreviation('р-н'));
        $this->assertFalse($filter->isAllowed($name, $code));
    }

    public function testDisallowCity()
    {
        $filter = new Abbreviation();
        $filter->not(['г']);
        $code = new Code('7877632487908');
        $name = new Name('город', new \rezident\KladrJson\row\Abbreviation('г'));
        $this->assertFalse($filter->isAllowed($name, $code));

        $name = new Name('город', new \rezident\KladrJson\row\Abbreviation('р-н'));
        $this->assertTrue($filter->isAllowed($name, $code));
    }

    public function testAllowAll()
    {
        $filter = new Abbreviation();
        $code = new Code('7877632487908');
        $name = new Name('город', new \rezident\KladrJson\row\Abbreviation('г'));
        $this->assertTrue($filter->isAllowed($name, $code));
        $name = new Name('город', new \rezident\KladrJson\row\Abbreviation('р-н'));
        $this->assertTrue($filter->isAllowed($name, $code));
    }
}
