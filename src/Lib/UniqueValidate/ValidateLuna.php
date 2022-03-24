<?php

namespace App\Lib\UniqueValidate;

use Rakit\Validation\Rule;

class ValidateLuna extends Rule
{
    #Проверка валидности карты алгоритмом Луна
    public function check($value): bool
    {
        if (!ctype_digit($value)) return false;
        $nDigits = strlen($value);
        #Проверка на количество цифр
        if ($nDigits != 16) return false;
        #Проверка алгоритмом Луна
        $sum = 0;
        $parity = $nDigits % 2;
        for ($i = 0; $i < $nDigits; $i++) {
            $digit = (int)$value[$i];
            if (($i % 2) === $parity) {$digit *= 2;}
            if ($digit > 9) {$digit -= 9;}
            $sum += $digit;
        }
        return ($sum % 10)  === 0;
    }
}