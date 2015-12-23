<?php

namespace rezident\KladrJson\row;


class Code
{

    /**
     * Код региона
     * @var int
     */
    public $region;

    /**
     * Код района
     * @var int
     */
    public $district;

    /**
     * Код города
     * @var int
     */
    public $city;

    /**
     * Код населенного пункта
     * @var int
     */
    public $locality;

    /**
     * Статус сайта
     * @var int
     */
    public $status;

    public function __construct($code)
    {
        list($this->region, $this->district, $this->city, $this->locality, $this->status) = sscanf($code, '%2d%3d%3d%3d%2d');
    }

    public function isAvailable()
    {
        return $this->status == 0;
    }
}