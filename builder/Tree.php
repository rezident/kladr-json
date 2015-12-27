<?php

namespace rezident\KladrJson\builder;


use Exception;
use rezident\KladrJson\row\Code;
use rezident\KladrJson\row\Name;

class Tree extends AbstractBuilder
{
    static public $merged = [];

    /**
     * @var Name[]
     */
    private $tree = [];

    public function buildPart(Name $name, Code $code) {
        $place = &$this->getPlaceOfTree($code);
        $place['name'] = $name;
        $place['code'] = $code;
    }

    private function &getPlaceOfTree(Code $code)
    {
        if(!$code->district && !$code->city && !$code->locality) {
            return $this->tree[$code->region];
        }

        if($code->district && !$code->city && !$code->locality) {
            return $this->tree[$code->region]['district'][$code->district];
        }

        if(!$code->district && $code->city && !$code->locality) {
            return $this->tree[$code->region]['city'][$code->city];
        }

        if(!$code->district && !$code->city && $code->locality) {
            return $this->tree[$code->region]['locality'][$code->locality];
        }

        if($code->district && $code->city && !$code->locality) {
            return $this->tree[$code->region]['district'][$code->district]['city'][$code->city];
        }

        if($code->district && !$code->city && $code->locality) {
            return $this->tree[$code->region]['district'][$code->district]['locality'][$code->locality];
        }

        if($code->district && $code->city && $code->locality) {
            return $this->tree[$code->region]['district'][$code->district]['city'][$code->city]['locality'][$code->locality];
        }

        if(!$code->district && $code->city && $code->locality) {
            return $this->tree[$code->region]['city'][$code->city]['locality'][$code->locality];
        }

        throw new Exception('Unknown place');
    }


    public function getAsJson()
    {
        $this->merge();
        $this->sort();
        return parent::getAsJson();
    }

    private function sort()
    {
        $sortFunction = function(array $a, array $b) {
            /** @var Name[] $a */
            /** @var Name[] $b */
            if(isset($a['name'], $b['name'])) {
                if($a['name']->getName() < $b['name']->getName()) {
                    return -1;
                }
                if($a['name']->getName() > $b['name']->getName()) {
                    return 1;
                }

            }

            return 0;
        };

        uasort($this->tree, $sortFunction);
        foreach(array_keys($this->tree) as $regionId) {
            if(isset($this->tree[$regionId]['district'])) {
                uasort($this->tree[$regionId]['district'], $sortFunction);
                foreach(array_keys($this->tree[$regionId]['district']) as $districtId) {
                    if(isset($this->tree[$regionId]['district'][$districtId]['city'])) {
                        uasort($this->tree[$regionId]['district'][$districtId]['city'], $sortFunction);
                        foreach(array_keys($this->tree[$regionId]['district'][$districtId]['city']) as $cityId) {
                            if(isset($this->tree[$regionId]['district'][$districtId]['city'][$cityId]['locality'])) {
                                uasort($this->tree[$regionId]['district'][$districtId]['city'][$cityId]['locality'], $sortFunction);
                            }

                        }

                    }

                }

            }

            if(isset($this->tree[$regionId]['city'])) {
                uasort($this->tree[$regionId]['city'], $sortFunction);
                foreach(array_keys($this->tree[$regionId]['city']) as $cityId) {
                    if(isset($this->tree[$regionId]['city'][$cityId]['locality'])) {
                        uasort($this->tree[$regionId]['city'][$cityId]['locality'], $sortFunction);
                    }

                }

            }

            if(isset($this->tree[$regionId]['locality'])) {
                uasort($this->tree[$regionId]['locality'], $sortFunction);
            }

        }

    }

    private function merge()
    {
        foreach (self::$merged as $from => $to) {
            if(isset($this->tree[$from]['district']) == false) {
                $this->tree[$from]['district'] = [];
            }
            if(isset($this->tree[$to]['district']) == false) {
                $this->tree[$to]['district'] = [];
            }
            $this->tree[$to]['district'] = array_merge($this->tree[$to]['district'], $this->tree[$from]['district']);

            if(isset($this->tree[$from]['city']) == false) {
                $this->tree[$from]['city'] = [];
            }
            if(isset($this->tree[$to]['city']) == false) {
                $this->tree[$to]['city'] = [];
            }
            $this->tree[$to]['city'] = array_merge($this->tree[$to]['city'], $this->tree[$from]['city']);

            if(isset($this->tree[$from]['city']) == false) {
                $this->tree[$from]['locality'] = [];
            }
            if(isset($this->tree[$to]['locality']) == false) {
                $this->tree[$to]['locality'] = [];
            }
            $this->tree[$to]['locality'] = array_merge($this->tree[$to]['locality'], $this->tree[$from]['locality']);

            unset($this->tree[$from]);
        }
    }
}
