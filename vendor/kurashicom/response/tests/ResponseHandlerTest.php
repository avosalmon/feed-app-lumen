<?php

use Kurashicom\Response\ResponseHandler;

class ResponseModuleTest extends PHPUnit_Framework_TestCase {

	/**
	 * Default preparation for each test
	 *
	 * @return void
	 */
	public function setUp()
	{
		parent::setUp();

		$this->responseMock = Mockery::mock('Illuminate\Contracts\Routing\ResponseFactory');

	}

	/**
	 * Default tear-down process for each test
	 *
	 * @return void
	 */
	public function tearDown()
	{
		Mockery::close();
	}

	/**
	 * Format a success response message.
	 *
	 * @return void
	 */
	protected function getSuccessMessage($data = array())
	{
		return array(
			'status'  => 'success',
			'data'    => $data,
			'message' => null
		);
	}

	/**
	 * Format an error response message.
	 *
	 * @return void
	 */
	protected function getErrorMessage($message = '')
	{
		return array(
			'status'  => 'error',
			'data'    => null,
			'message' => $message
		);
	}

	/**
	 * Should return proper formatted success response.
	 *
	 * @return void
	 */
	public function testSuccessResponse()
	{
		$this->responseMock->shouldReceive('json')->once()->with($this->getSuccessMessage(), '200');

		$response = new ResponseHandler($this->responseMock, array(), array());

		$response->success();
	}

	/**
	 * Should return proper formatted success response.
	 *
	 * @return void
	 */
	public function testSuccessResponseWithData()
	{
		$data = array('product' => 'supercoolproduct');

		$this->responseMock->shouldReceive('json')->once()->with($this->getSuccessMessage($data), '200');

		$response = new ResponseHandler($this->responseMock, array(), array());

		$response->success($data);
	}

	/**
	 * Should return proper formatted success response.
	 *
	 * @return void
	 */
	public function testSuccessResponseWithCustomCode()
	{
		$data = array('product' => 'supercoolproduct');

		$this->responseMock->shouldReceive('json')->once()->with($this->getSuccessMessage($data), '203');

		$response = new ResponseHandler($this->responseMock, array(), array());

		$response->success($data, '203');
	}

	/**
	 * Should return proper formatted error response.
	 *
	 * @return void
	 */
	public function testErrorResponse()
	{
		$this->responseMock->shouldReceive('json')->once()->with($this->getErrorMessage('Bad Request! (400)'), '400');

		$response = new ResponseHandler($this->responseMock, array(), array());

		$response->error();
	}

	/**
	 * Should return proper formatted error response.
	 *
	 * @return void
	 */
	public function testErrorResponseWithCustomCode()
	{
		$this->responseMock->shouldReceive('json')->once()->with($this->getErrorMessage('Unauthorized! (401)'), '401');

		$response = new ResponseHandler($this->responseMock, array(), array());

		$response->error('', '401');
	}

	/**
	 * Should return proper formatted success response.
	 *
	 * @return void
	 */
	public function testSuccessResponseActions()
	{
		$this->responseMock->shouldReceive('json')->once()->with($this->getSuccessMessage(), '200');

		$action = Mockery::mock('mockAction');
		$action->shouldReceive('fire')->once()->with(array(), '200');

		$response = new ResponseHandler($this->responseMock, array($action), array());

		$response->success();
	}

	/**
	 * Should return proper formatted success response.
	 *
	 * @return void
	 */
	public function testErrorResponseActions()
	{
		$this->responseMock->shouldReceive('json')->once()->with($this->getErrorMessage('Bad Request! (400)'), '400');

		$action = Mockery::mock('mockAction');
		$action->shouldReceive('fire')->with('', '400')->once();

		$response = new ResponseHandler($this->responseMock, array(), array($action));

		$response->error();
	}

}
