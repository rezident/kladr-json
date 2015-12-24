<?php

namespace rezident\KladrJson\tests\row;


use rezident\KladrJson\row\Code;

class CodeTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $code = new Code('7801025521500');
        $this->assertEquals(78, $code->region);
        $this->assertEquals(10, $code->district);
        $this->assertEquals(255, $code->city);
        $this->assertEquals(215, $code->locality);
        $this->assertEquals(0, $code->status);
        $this->assertTrue($code->isAvailable());
    }

    public function testNotAvailable()
    {
        $code = new Code('7801025521501');
        $this->assertFalse($code->isAvailable());
    }

    public function testGetLevel()
    {
        $code = new Code('7800000000000');
        $this->assertEquals(0, $code->getLevel());

        $code = new Code('7800100000000');
        $this->assertEquals(1, $code->getLevel());

        $code = new Code('7800000100000');
        $this->assertEquals(1, $code->getLevel());

        $code = new Code('7800000000100');
        $this->assertEquals(1, $code->getLevel());

        $code = new Code('7800100100000');
        $this->assertEquals(2, $code->getLevel());

        $code = new Code('7800100000100');
        $this->assertEquals(2, $code->getLevel());

        $code = new Code('7800000100100');
        $this->assertEquals(2, $code->getLevel());

        $code = new Code('7800100100100');
        $this->assertEquals(3, $code->getLevel());
    }
}
