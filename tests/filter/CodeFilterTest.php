<?php

namespace rezident\KladrJson\tests\filter;

use rezident\KladrJson\filter\CodeFilter;
use rezident\KladrJson\row\Abbreviation;
use rezident\KladrJson\row\Code;
use rezident\KladrJson\row\Name;

class CodeFilterTest extends \PHPUnit_Framework_TestCase
{
    public function testRegion()
    {
        $code = new Code('7801002003000');
        $name = new Name('z', new Abbreviation('г'));

        $filter = new CodeFilter(['region' => 78]);
        $this->assertTrue($filter->isAllowed($name, $code));
        $filter = new CodeFilter(['region' => 73]);
        $this->assertFalse($filter->isAllowed($name, $code));
    }

    public function testDistrict()
    {
        $code = new Code('7801002003000');
        $name = new Name('z', new Abbreviation('г'));

        $filter = new CodeFilter(['district' => 10]);
        $this->assertTrue($filter->isAllowed($name, $code));
        $filter = new CodeFilter(['district' => 11]);
        $this->assertFalse($filter->isAllowed($name, $code));
    }

    public function testCity()
    {
        $code = new Code('7801002003000');
        $name = new Name('z', new Abbreviation('г'));

        $filter = new CodeFilter(['city' => 20]);
        $this->assertTrue($filter->isAllowed($name, $code));
        $filter = new CodeFilter(['city' => 11]);
        $this->assertFalse($filter->isAllowed($name, $code));
    }

    public function testLocality()
    {
        $code = new Code('7801002003000');
        $name = new Name('z', new Abbreviation('г'));

        $filter = new CodeFilter(['locality' => 30]);
        $this->assertTrue($filter->isAllowed($name, $code));
        $filter = new CodeFilter(['locality' => 11]);
        $this->assertFalse($filter->isAllowed($name, $code));
    }

    public function testDistrictAndCity()
    {
        $code = new Code('7801002003000');
        $name = new Name('z', new Abbreviation('г'));

        $filter = new CodeFilter(['district' => 10, 'city' => 20]);
        $this->assertTrue($filter->isAllowed($name, $code));
        $filter = new CodeFilter(['district' => 10, 'city' => 21]);
        $this->assertFalse($filter->isAllowed($name, $code));
        $filter = new CodeFilter(['district' => 11, 'city' => 20]);
        $this->assertFalse($filter->isAllowed($name, $code));
    }
}
