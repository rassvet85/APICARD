<?php

namespace App\Lib;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;


class Log
{
    protected mixed $log;

    protected array $errorCode = [
        'OK',
        'Validate',
        'Encrypt',
        'ER0003',
        'ER0004',
        'ER0005',
        'ER0006',
        'ER0007',
        'ER0008',
        'ER0009'
    ];

    public function init($name)
    {
        $output = "%datetime% %level_name% %message% %context%\n";

        $formatter = new LineFormatter($output, "Y-m-d H:i:s");

        $stream = new StreamHandler(DIRROOT . LOG_FILE, Logger::INFO);
        $stream->setFormatter($formatter);

        $this->log = new Logger($name);
        $this->log->pushHandler($stream);
    }

    public function error($code,$value)
    {
        $this->log->error($this->errorCode[$code],$value);
    }

    public function info($value)
    {
        $this->log->info($this->errorCode[0],$value);
    }

}