<?php

namespace App\Lib;

class MakeToken
{
    public function makeToken($value): array
    {
        #добавляем в массив запроса tokenExpire
        $tokenExpire =  strtotime("now") + (int) tokenTTL;
        $value['tokenExpire'] = $tokenExpire;

        return $value;
    }
}