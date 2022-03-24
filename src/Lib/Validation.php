<?php

namespace App\Lib;

use App\Lib\UniqueValidate\ValidateExpireCard;
use Rakit\Validation\ErrorBag;
use Rakit\Validation\RuleQuashException;
use Rakit\Validation\Validator;
use App\Lib\UniqueValidate\ValidateLuna;
use function Sodium\add;

class Validation
{

    protected ErrorBag $errors;

    /**
     * @throws RuleQuashException
     */
    public function validate($value): bool
    {
        if (!is_array($value)) {
            $errorbag = new ErrorBag();
            $errorbag->add('data','null', 'incoming data not json array');
            $this->errors = $errorbag;
            return false;
        }
        $validator = new Validator();
        $validator->addValidator('luna', new ValidateLuna());
        $validator->addValidator('expirecard', new ValidateExpireCard());
        $validation = $validator->make($value, [
            'pan'                   => 'required|digits:16|luna',
            'cvc'                   => 'required|digits:3',
            'cardholder'            => 'required|regex:/^[A-Za-z]+\s[A-Za-z]+$/',
            'expire'                => 'required|expirecard'
        ]);
        #Валидация данных
        $validation->validate();

        $this->errors = $validation->errors();

       return !$validation->fails();
    }

    public function errors(): ErrorBag
    {
        return $this->errors;
    }

}