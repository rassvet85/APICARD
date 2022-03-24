<?php
namespace App\Controllers;

use App\Lib\Encrypt;
use App\Lib\Log;
use App\Lib\MakeToken;
use Comet\Request;
use Comet\Response;
use App\Lib\Validation;



class Controllertest
{
    /**
     * @throws \Rakit\Validation\RuleQuashException
     */
    public function getToken(Request $request, Response $response): Response
    {
        $body = json_decode($request->getBody(), true);

        #Создаем лог
        $log = new Log();
        $log->init("Apilog");

        #Валидация данных
        $validator = new Validation();
        if (!$validator->validate($body))
        {
            $log->error(1, $validator->errors()->firstOfAll());
            return $response->with(["error" => $validator->errors()->firstOfAll()],400);
        }

        #добавляем в массив запроса tokenExpire
        $makeToken = new MakeToken();
        $body = $makeToken->makeToken($body);

        $encrypt = new Encrypt();
        if (!$encrypt->encrypt($body))
        {
            $log->error(2, 'Encoding error');
            return $response->with(["error" => "Encoding error"],400);
        }
        $outbody = $encrypt->data();

        #отправляем финальный ответ
        $log->info($outbody);
        return $response->with($outbody);
    }
} 