<?php

namespace App\Lib;

class Encrypt
{
    protected array $outbody;

    public function encrypt($value): bool
    {
        #кодируем данные
        if (!openssl_public_encrypt(json_encode($value),$output,openssl_pkey_get_public(file_get_contents(DIRROOT . KEY_PUBLIC)))) return false;
        $token = base64_encode($output);
        $pub_sub = substr_replace($value['pan'],'**',4,8);
        $this->outbody = ["pan" => $pub_sub, "token" => $token];
        return true;
    }

    public function data(): array
    {
        return $this->outbody;
    }
}