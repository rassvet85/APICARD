<?php

use Comet\Comet;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';

const DIRROOT = __DIR__;

date_default_timezone_set("Europe/Moscow");

$app = new Comet(['debug' => true]);

$app->post('/api/token', 'App\Controllers\Controllertest:getToken');

$app->run();
?>