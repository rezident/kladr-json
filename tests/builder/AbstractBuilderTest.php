<?php

namespace rezident\KladrJson\tests\builder;


use PHPUnit_Framework_MockObject_MockObject;
use rezident\KladrJson\builder\AbstractBuilder;

class AbstractBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testGetAsJson()
    {
        /** @var PHPUnit_Framework_MockObject_MockObject|AbstractBuilder $mock */
        $mock = $this->getMockForAbstractClass(AbstractBuilder::class);
        $this->assertEquals('[]', $mock->getAsJson());
    }
}
