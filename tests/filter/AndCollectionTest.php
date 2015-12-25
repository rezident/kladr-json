<?php

namespace rezident\KladrJson\tests\filter;


use rezident\KladrJson\filter\AndCollection;
use rezident\KladrJson\filter\InterfaceFilter;
use rezident\KladrJson\row\Abbreviation;
use rezident\KladrJson\row\Code;
use rezident\KladrJson\row\Name;

class AndCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testIsAllowed()
    {
        $filter = new AndCollection([$this->getInterfaceFilterMock(true)]);
        $this->assertTrue($filter->isAllowed(new Name('name', new Abbreviation('г')), new Code('7800000000000')));
    }

    public function testIsNotAllowed()
    {
        $filter = new AndCollection([$this->getInterfaceFilterMock(false)]);
        $this->assertFalse($filter->isAllowed(new Name('name', new Abbreviation('г')), new Code('7800000000000')));
    }

    public function testAllowedAndNotAllowed()
    {
        $filter = new AndCollection([$this->getInterfaceFilterMock(true), $this->getInterfaceFilterMock(false)]);
        $this->assertFalse($filter->isAllowed(new Name('name', new Abbreviation('г')), new Code('7800000000000')));
    }

    private function getInterfaceFilterMock($return) {
        $filterMock = $this->getMock(InterfaceFilter::class);
        $filterMock->method('isAllowed')->willReturn($return);
        return $filterMock;
    }
}
