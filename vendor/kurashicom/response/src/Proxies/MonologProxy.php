<?php namespace Kurashicom\Response\Proxies;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger as Monolog;

class MonologProxy
{

    /**
     * Instantiate Monolog and return the instance.
     *
     * @param  string $log
     * @return Monolog\Logger
     */
    public function getMonolog($log)
    {
        $logger    = new Monolog('logger');
        $handler   = new StreamHandler(storage_path() . '/logs/' . $log . '.log');
        $formatter = new LineFormatter($format = null, $dateFormat = null, $allowInlineLineBreaks = true);

        $handler->setFormatter($formatter);
        $logger->pushHandler($handler);

        return $logger;
    }
}
