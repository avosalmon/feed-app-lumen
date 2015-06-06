<?php namespace Kurashicom\Response\Actions;

use Illuminate\Http\Request;
use Kurashicom\Response\Proxies\DotEnvProxy;
use Kurashicom\Response\Proxies\MonologProxy;

class Logger
{

    /**
     * The Monolog implementation holder.
     *
     * @var Kurashicom\Response\Proxies\MonologProxy
     */
    protected $log;

    /**
     * The DotEnvProxy implementation holder.
     *
     * @var Kurashicom\Response\Proxies\DotEnvProxy
     */
    protected $env;

    /**
     * The Request implementation.
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * Assign dependencies to class properties.
     *
     * @param  Kurashicom\Response\Proxies\MonologProxy $log
     * @param  Kurashicom\Response\Proxies\DotEnvProxy $env
     * @param  Illuminate\Http\Request $request
     * @return void
     */
    public function __construct(MonologProxy $log, DotEnvProxy $env, Request $request)
    {
        $this->log     = $log;
        $this->env     = $env;
        $this->request = $request;
    }

    /**
     * Log action.
     *
     * @param  string $message
     * @param  string $log
     * @return void
     */
    public function fire($message = '', $log = '400')
    {
        if ($this->env->get('APP_ENV') == 'testing') {
            return $this->logToConsole($message);
        }

        return $this->logToFile($message, $log);
    }

    /**
     * Log to file.
     *
     * @param  string $message
     * @param  string $log
     * @return void
     */
    public function logToFile($message = '', $log = '400')
    {
        $log = $this->log->getMonolog($log);

        if ($message === '') {
            $message = $this->request->server('REQUEST_METHOD') . ' ' . $this->request->server('REQUEST_URI') . ' | ' . $this->request->server('HTTP_X_REAL_IP') . ' (' . $this->request->server('REMOTE_ADDR') . ') | ';
        }

        $log->addError(var_export($message, true), $this->request->input());
    }

    /**
     * Log to console.
     *
     * @param  string $message
     * @return void
     */
    public function logToConsole($message = '')
    {
        echo "\033[32m" . var_export($message, true) . "\033[39m";
    }
}
