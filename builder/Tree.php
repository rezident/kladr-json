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
        $this->data = $this->getImportTree($this->tree);
        return parent::getAsJson();
    }

    private function getImportTree($branch)
    {
        $importTree = [];
        foreach($branch as $leaf) {
            if(isset($leaf['name'])) {
                /** @var Name $name */
                /** @var Code $code */
                $name = $leaf['name'];
                $code = $leaf['code'];
                $item = [
                    'name' => $name->__toString(),
                    'region' => $code->region
                ];

                if($code->district) {
                    $item['district'] = $code->district;
                }
                if($code->city) {
                    $item['city'] = $code->city;
                }
                if($code->locality) {
                    $item['locality'] = $code->locality;
                }
                $item['letter'] = mb_substr(mb_strtoupper($name->getName()), 0, 1);

                $districts = (isset($leaf['district'])) ? $this->getImportTree($leaf['district']) : [];
                $cities = (isset($leaf['city'])) ? $this->getImportTree($leaf['city']) : [];
                $localities = (isset($leaf['locality'])) ? $this->getImportTree($leaf['locality']) : [];
                $children = array_merge($cities, $districts, $localities);
                if(count($children)) {
                    $item['children'] = $children;
                }

                $importTree[] = $item;
            }

        }

        return $importTree;
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

            if(isset($this->tree[$from]['locality']) == false) {
                $this->tree[$from]['locality'] = [];
            }
            if(isset($this->tree[$to]['locality']) == false) {
                $this->tree[$to]['locality'] = [];
            }
            $this->tree[$to]['locality'] = array_merge($this->tree[$to]['locality'], $this->tree[$from]['locality']);

            /** @var Name $toName */
            /** @var Name $fromName */
            /** @var Code $toCode */
            /** @var Code $fromCode */
            $toName = $this->tree[$to]['name'];
            $fromName = $this->tree[$from]['name'];
            $toCode = $this->tree[$to]['code'];
            $fromCode = $this->tree[$from]['code'];
            $this->tree[$to]['name'] = new Name($toName->getName() . ' и ' . $fromName->__toString(), $toName->getAbbreviation());
            $toCode->region = [$toCode->region, $fromCode->region];
            unset($this->tree[$from]);
        }
    }
}
