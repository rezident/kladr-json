<?php

namespace rezident\KladrJson\tests\filter;


use rezident\KladrJson\filter\Negative;
use rezident\KladrJson\filter\Status;
use rezident\KladrJson\row\Abbreviation;
use rezident\KladrJson\row\Code;
use rezident\KladrJson\row\Name;

class NegativeTest extends \PHPUnit_Framework_TestCase
{
    public function testFilter()
    {
        $code = new Code('7600000000055');
        $name = new Name('ааа', new Abbreviation('г'));
        $filter = new Status();
        $negativeFilter = new Negative($filter);
        $this->assertTrue($negativeFilter->isAllowed($name, $code));

        $code->status = 0;
        $this->assertFalse($negativeFilter->isAllowed($name, $code));
    }
}
