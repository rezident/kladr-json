<?php

namespace rezident\KladrJson\filter;


abstract class CollectionAbstract implements InterfaceFilter
{
    /**
     * @var InterfaceFilter[]
     */
    protected $filters = [];

    /**
     * @param InterfaceFilter[] $filters
     */
    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function add(InterfaceFilter $filter)
    {
        $this->filters[] = $filter;
    }

}