<?php

namespace rezident\KladrJson;


use rezident\KladrJson\builder\AbstractBuilder;
use rezident\KladrJson\exceptions\UnknownAbbrException;
use rezident\KladrJson\filter\CollectionAbstract;
use rezident\KladrJson\row\Abbreviation;
use rezident\KladrJson\row\Code;
use rezident\KladrJson\row\Name;
use rezident\KladrJson\row\Scheme;
use XBase\Table;

class Application
{

    public function run(CollectionAbstract $filter, AbstractBuilder $builder)
    {

        $table = new Table('files/KLADR.DBF', null, 'CP866');

        $lookOnlyAbbr = false;
        /** @var Scheme $row */
        while($row = $table->nextRecord()) {
            if($lookOnlyAbbr && $row->socr != $lookOnlyAbbr) {
                continue;
            }

            try {
                $abbr = new Abbreviation($row->socr);
                $code = new Code($row->code);
                $name = new Name($row->name, $abbr);
                if($filter->isAllowed($name, $code)) {
                    $builder->buildPart($name, $code);
                }
            } catch (UnknownAbbrException $e) {
                $lookOnlyAbbr = $row->socr;
                echo $row->code . ' ' . $row->socr . ' ' . $row->name . PHP_EOL;
            }


        }
    }
}