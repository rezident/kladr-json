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
}
