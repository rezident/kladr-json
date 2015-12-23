<?php


namespace rezident\KladrJson;

require 'vendor/autoload.php';

use classes\Abbreviation;
use classes\Code;
use classes\RowScheme;
use XBase\Table;



$table = new Table('files/KLADR.DBF', null, 'CP866');

/** @var RowScheme $row */
while($row = $table->nextRecord()) {
    $code = new Code($row->code);
    $abbr = new Abbreviation($row->socr);
}