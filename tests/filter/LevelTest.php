<?php

namespace rezident\KladrJson\tests\filter;


use rezident\KladrJson\filter\Level;
use rezident\KladrJson\row\Abbreviation;
use rezident\KladrJson\row\Code;
use rezident\KladrJson\row\Name;

class LevelTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Name
     */
    public $name;

    public function setUp()
    {
        parent::setUp();
        $this->name = new Name('Пушкин', new Abbreviation('г'));
    }


    public function testLevelOk()
    {
        $filter = new Level(2);
        $code = new Code('7801005000000');
        $this->assertTrue($filter->isAllowed($this->name, $code));
    }

    public function testLevelError()
    {
        $filter = new Level(2);
        $code = new Code('7805002003000');
        $this->assertFalse($filter->isAllowed($this->name, $code));
    }

    public function testDiapasonOk()
    {
        $filter = new Level([2, 3]);
        $code = new Code('7805002003000');
        $this->assertTrue($filter->isAllowed($this->name, $code));
    }

    public function testDiapasonError()
    {
        $filter = new Level([2, 3]);
        $code = new Code('7805000000000');
        $this->assertFalse($filter->isAllowed($this->name, $code));
    }

    public function testLessOk()
    {
        $filter = new Level([null, 2]);
        $code = new Code('7805000000000');
        $this->assertTrue($filter->isAllowed($this->name, $code));
    }

    public function testLessError()
    {
        $filter = new Level([null, 2]);
        $code = new Code('7805001001000');
        $this->assertFalse($filter->isAllowed($this->name, $code));
    }

    public function testLargerOk()
    {
        $filter = new Level([2]);
        $code = new Code('7805001001000');
        $this->assertTrue($filter->isAllowed($this->name, $code));
    }

    public function testLargerError()
    {
        $filter = new Level([2]);
        $code = new Code('7805000000000');
        $this->assertFalse($filter->isAllowed($this->name, $code));
    }
}
