<?php

namespace App\Lib\UniqueValidate;

use Rakit\Validation\Rule;

class ValidateExpireCard extends Rule
{
    #Проверка валидности срока действия карты
    public function check($value): bool
    {
        preg_match('/^(0[1-9]|1[0-2])\/(\d{2})$/',$value, $matches);

        if (count($matches) == 3 && ($matches[2]*12 + $matches[1]) >= (date('y')*12 + date('m') )) {
            return true;
        }
        return false;
    }
}