<?php

namespace rezident\KladrJson;


use rezident\KladrJson\row\Abbreviation;
use rezident\KladrJson\row\Code;
use rezident\KladrJson\row\Scheme;
use XBase\Table;

class Application
{

    public function run()
    {

        $table = new Table('files/KLADR.DBF', null, 'CP866');

        /** @var Scheme $row */
        while($row = $table->nextRecord()) {
            $code = new Code($row->code);
            $abbr = new Abbreviation($row->socr);
        }
    }
}