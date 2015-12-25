<?php
/**
 * Created by PhpStorm.
 * User: yuri
 * Date: 25.12.15
 * Time: 23:19
 */

namespace rezident\KladrJson\tests\filter;


use rezident\KladrJson\filter\CodeFilter;
use rezident\KladrJson\filter\OrCollection;
use rezident\KladrJson\filter\Status;
use rezident\KladrJson\row\Abbreviation;
use rezident\KladrJson\row\Code;
use rezident\KladrJson\row\Name;

class OrCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testFilter()
    {
        $code = new Code('7801000000001');
        $name = new Name('Пушкин', new Abbreviation('г'));

        $statusFilter = new Status();
        $codeFilter = new CodeFilter(['region' => 78]);
        $collection = new OrCollection([$statusFilter, $codeFilter]);
        $this->assertTrue($collection->isAllowed($name, $code));
    }
}
