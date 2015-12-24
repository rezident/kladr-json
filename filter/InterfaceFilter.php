<?php

namespace rezident\KladrJson\filter;


use rezident\KladrJson\row\Code;
use rezident\KladrJson\row\Name;

interface InterfaceFilter
{
    /**
     * Проверяет имя и сокращения на разрешенность использования
     *
     * @param Name $name Имя географического пункта
     * @param Code $code Код региона
     *
     * @return bool Разрешено ли его использовать
     */
    public function isAllowed(Name $name, Code $code);
}