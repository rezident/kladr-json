<?php

namespace rezident\KladrJson\tests\filter;


use rezident\KladrJson\filter\Status;
use rezident\KladrJson\row\Abbreviation;
use rezident\KladrJson\row\Code;
use rezident\KladrJson\row\Name;

class StatusTest extends \PHPUnit_Framework_TestCase
{

    public function testFilter()
    {
        $name = new Name('name', new Abbreviation('г'));
        $code = new Code('3200000000000');
        $filter = new Status();
        $this->assertTrue($filter->isAllowed($name, $code));

        $code = new Code('3200000000044');
        $this->assertFalse($filter->isAllowed($name, $code));
    }
}
