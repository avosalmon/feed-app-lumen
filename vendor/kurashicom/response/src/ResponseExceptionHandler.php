<?php namespace Kurashicom\Response;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ResponseExceptionHandler
{

    /**
     * The ResponseHandler implementation.
     *
     * @var Kurashicom\Response\ResponseHandler
     */
    protected $response;

    /**
     * Create new instances for dependencies.
     *
     * @param  Kurashicom\Response\ResponseHandler $response
     * @return void
     */
    public function __construct(ResponseHandler $response)
    {
        $this->response = $response;
    }

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        //
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            return $this->response->error('', '404');
        }

        if ($exception instanceof ModelNotFoundException) {
            return $this->response->error('', '404');
        }

        return $this->response->error((string)$exception, '500');
    }

    /**
     * Render an exception to the console.
     *
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @param  \Exception  $exception
     * @return void
     */
    public function renderForConsole($output, Exception $exception)
    {
        return $this->response->error((string)$exception, '500');
    }
}
