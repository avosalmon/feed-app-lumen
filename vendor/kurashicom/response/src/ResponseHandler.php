<?php namespace Kurashicom\Response;

use Illuminate\Contracts\Routing\ResponseFactory;

class ResponseHandler {

	/**
	 * The ResponseFactory implementation.
	 *
	 * @var Illuminate\Contracts\Routing\ResponseFactory
	 */
	protected $response;

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
	 * @param  Illuminate\Contracts\Routing\ResponseFactory $response
	 * @param  array $successActions
	 * @param  array $errorActions
	 * @return void
	 */
	public function __construct(ResponseFactory $response, $successActions, $errorActions)
	{
		$this->response = $response;
		$this->successActions = $successActions;
		$this->errorActions = $errorActions;
	}

	/**
	 * Generate a success response.
	 *
	 * @param  array  $data
	 * @param  string $code
	 * @return Illuminate\Support\Facades\Response
	 */
	public function success($data = array(), $code = '200')
	{
		foreach($this->successActions as $action)
		{
			$action->fire($data, $code);
		}

		$response = array(
			'status'  => 'success',
			'data'    => $data,
			'message' => null
		);

		return $this->response->json($response, $code);
	}

	/**
	 * Generate an error response.
	 *
	 * @param  mixed  $exception
	 * @param  string $code
	 * @return mixed
	 */
	public function error($exception = '', $code = '400')
	{
		foreach($this->errorActions as $action)
		{
			$action->fire($exception, $code);
		}

		$response = array(
			'status'  => 'error',
			'data'    => null,
			'message' => $this->errorMessage($code)
		);

		return $this->response->json($response, $code);
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
