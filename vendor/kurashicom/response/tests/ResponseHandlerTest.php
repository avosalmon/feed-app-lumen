<?php

use Kurashicom\Response\ResponseHandler;

class ResponseModuleTest extends PHPUnit_Framework_TestCase
{

    /**
     * Default preparation for each test
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->responseMock = Mockery::mock('Laravel\Lumen\Http\ResponseFactory');
        $this->viewMock     = Mockery::mock('Illuminate\Contracts\View\Factory');
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
    protected function getSuccessMessage($data = [])
    {
        return [
            'status'  => 'success',
            'data'    => $data,
            'message' => null
        ];
    }

    /**
     * Format an error response message.
     *
     * @return void
     */
    protected function getErrorMessage($message = '')
    {
        return [
            'status'  => 'error',
            'data'    => null,
            'message' => $message
        ];
    }

    /**
     * Should return proper formatted success response.
     *
     * @return void
     */
    public function testSuccessResponse()
    {
        $this->responseMock->shouldReceive('json')->once()->with($this->getSuccessMessage(), '200');

        $response = new ResponseHandler($this->responseMock, $this->viewMock, [], []);

        $response->success();
    }

    /**
     * Should return proper formatted success response.
     *
     * @return void
     */
    public function testSuccessResponseWithData()
    {
        $data = ['product' => 'supercoolproduct'];

        $this->responseMock->shouldReceive('json')->once()->with($this->getSuccessMessage($data), '200');

        $response = new ResponseHandler($this->responseMock, $this->viewMock, [], []);

        $response->success($data);
    }

    /**
     * Should return proper formatted success response.
     *
     * @return void
     */
    public function testSuccessResponseWithCustomCode()
    {
        $data = ['product' => 'supercoolproduct'];

        $this->responseMock->shouldReceive('json')->once()->with($this->getSuccessMessage($data), '203');

        $response = new ResponseHandler($this->responseMock, $this->viewMock, [], []);

        $response->success($data, '203');
    }

    /**
     * Should return proper formatted success response.
     *
     * @return void
     */
    public function testSuccessViewResponse()
    {
        $data = ['product' => 'supercoolproduct'];

        $this->viewMock->shouldReceive('make')->once()->with('pages.product', $this->getSuccessMessage($data))->andReturn('a');
        $this->responseMock->shouldReceive('make')->once()->with('a', '200');

        $response = new ResponseHandler($this->responseMock, $this->viewMock, [], []);

        $response->success($data, '200', 'pages.product');
    }

    /**
     * Should return proper formatted error response.
     *
     * @return void
     */
    public function testErrorResponse()
    {
        $this->responseMock->shouldReceive('json')->once()->with($this->getErrorMessage('Bad Request! (400)'), '400');

        $response = new ResponseHandler($this->responseMock, $this->viewMock, [], []);

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

        $response = new ResponseHandler($this->responseMock, $this->viewMock, [], []);

        $response->error('', '401');
    }

    /**
     * Should return proper formatted error response.
     *
     * @return void
     */
    public function testErrorViewResponse()
    {
        $this->viewMock->shouldReceive('make')->once()->with('pages.product', $this->getErrorMessage('Bad Request! (400)'))->andReturn('a');
        $this->responseMock->shouldReceive('make')->once()->with('a', '400');

        $response = new ResponseHandler($this->responseMock, $this->viewMock, [], []);

        $response->error($exception = '', '400', 'pages.product');
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
        $action->shouldReceive('fire')->once()->with([], '200');

        $response = new ResponseHandler($this->responseMock, $this->viewMock, [$action], []);

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

        $response = new ResponseHandler($this->responseMock, $this->viewMock, [], [$action]);

        $response->error();
    }
}
