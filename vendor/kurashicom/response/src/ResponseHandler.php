<?php namespace Kurashicom\Response;

use Laravel\Lumen\Http\ResponseFactory;
use Illuminate\Contracts\View\Factory as ViewFactory;

class ResponseHandler
{
    /**
     * The ResponseFactory implementation.
     *
     * @var Laravel\Lumen\Http\ResponseFactory
     */
    protected $response;

    /**
     * Variable to hold the instance of the injected dependency.
     *
     * @var Illuminate\Contracts\View\Factory
     */
    protected $view;

    /**
     * Success actions array.
     *
     * @var array
     */
    protected $successActions;

    /**
     * Error actions array.
     *
     * @var array
     */
    protected $errorActions;

    /**
     * Create new instances for dependencies.
     *
     * @param  Laravel\Lumen\Http\ResponseFactory $response
     * @param  Illuminate\Contracts\View\Factory $view
     * @param  array $successActions
     * @param  array $errorActions
     * @return void
     */
    public function __construct(ResponseFactory $response, ViewFactory $view, $successActions, $errorActions)
    {
        $this->response       = $response;
        $this->view           = $view;
        $this->successActions = $successActions;
        $this->errorActions   = $errorActions;
    }

    /**
     * Generate a success response.
     *
     * @param  array  $data
     * @param  string $code
     * @param  string $view
     * @return Illuminate\Support\Facades\Response
     */
    public function success($data = [], $code = '200', $view = '')
    {
        foreach ($this->successActions as $action) {
            $action->fire($data, $code);
        }

        $data = [
            'status'  => 'success',
            'data'    => $data,
            'message' => null
        ];

        if ($view) {
            return $this->viewResponse($view, $data, $code);
        } else {
            return $this->jsonResponse($data, $code);
        }
    }

    /**
     * Generate an error response.
     *
     * @param  mixed  $exception
     * @param  string $code
     * @return mixed
     */
    public function error($exception = '', $code = '400', $view = '')
    {
        foreach ($this->errorActions as $action) {
            $action->fire($exception, $code);
        }

        $data = [
            'status'  => 'error',
            'data'    => null,
            'message' => $this->errorMessage($code)
        ];

        if ($view) {
            return $this->viewResponse($view, $data, $code);
        } else {
            return $this->jsonResponse($data, $code);
        }
    }

    /**
     * Generate a json response.
     *
     * @param  array  $data
     * @param  string $code
     * @return Illuminate\Support\Facades\Response
     */
    protected function jsonResponse($data = [], $code)
    {
        return $this->response->json($data, $code);
    }

    /**
     * Generate a view response.
     *
     * @param  string $view
     * @param  array  $data
     * @param  string $code
     * @return Illuminate\Support\Facades\Response
     */
    protected function viewResponse($view, $data = [], $code)
    {
        return $this->response->make($this->view->make($view, $data), $code);
    }

    /**
     * Get default error message.
     *
     * @return string  $code
     */
    protected function errorMessage($code)
    {
        switch ($code) {
            case '400':
                $message = 'Bad Request! (400)';
                break;
            case '401':
                $message = 'Unauthorized! (401)';
                break;
            case '404':
                $message = 'Not Found! (404)';
                break;
            case '500':
                $message = 'Server Error! (500)';
                break;
            default:
                $message = '';
        }
        return $message;
    }
}
