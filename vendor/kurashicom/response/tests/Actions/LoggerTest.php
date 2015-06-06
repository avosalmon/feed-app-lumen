<?php

class LoggerTest extends PHPUnit_Framework_TestCase {

	/**
	 * Default preparation for each test
	 *
	 * @return void
	 */
	public function setUp()
	{
		parent::setUp();

		//Dependency mocks
		$this->logMock     = Mockery::mock('Kurashicom\Response\Proxies\MonologProxy');
		$this->requestMock = Mockery::mock('Illuminate\Http\Request');
		$this->monologMock = Mockery::mock('Monolog\Logger');
		$this->envMock     = Mockery::mock('Kurashicom\Response\Proxies\DotEnvProxy');

		//Monolog instance
		$this->log = Mockery::mock('Kurashicom\Response\Actions\Logger[logToConsole]', [$this->logMock, $this->envMock, $this->requestMock]);
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
	 * Should log given message.
	 *
	 * @return void
	 */
	public function testShouldLogToFileWithMessage()
	{
		$this->envMock->shouldReceive('get')->once()->with('APP_ENV')->andReturn('development');
		$requestParams = ['id' => 3];
		$errorMessage  = 'post not found!';

		$this->logMock->shouldReceive('getMonolog')->once()->with('400')->andReturn($this->monologMock);
		$this->requestMock->shouldReceive('input')->once()->andReturn($requestParams);
		$this->monologMock->shouldReceive('addError')->once()->with(var_export($errorMessage, true), $requestParams);

		$this->log->fire($errorMessage);
	}

	/**
	 * Should log given message.
	 *
	 * @return void
	 */
	public function testShouldLogToFileWithArrayMessage()
	{
		$this->envMock->shouldReceive('get')->once()->with('APP_ENV')->andReturn('development');
		$requestParams = ['id' => 3];
		$errorMessage  = ['somemessage' => 'post not found!'];

		$this->logMock->shouldReceive('getMonolog')->once()->with('400')->andReturn($this->monologMock);
		$this->requestMock->shouldReceive('input')->once()->andReturn($requestParams);
		$this->monologMock->shouldReceive('addError')->once()->with(var_export($errorMessage, true), $requestParams);

		$this->log->fire($errorMessage);
	}

	/**
	 * Should log given message.
	 *
	 * @return void
	 */
	public function testShouldLogToFileWithFallbackToDefaultErrorMessage()
	{
		$this->envMock->shouldReceive('get')->once()->with('APP_ENV')->andReturn('development');
		$requestParams   = ['id' => 3];
		$expectedMessage = 'GET / | 10.0.0.1 (localhost) | ';

		$this->logMock->shouldReceive('getMonolog')->once()->with('400')->andReturn($this->monologMock);
		$this->requestMock->shouldReceive('server')->times(4)->andReturn('GET', '/', '10.0.0.1', 'localhost');
		$this->requestMock->shouldReceive('input')->once()->andReturn($requestParams);
		$this->monologMock->shouldReceive('addError')->once()->with(var_export($expectedMessage, true), $requestParams);

		$this->log->fire();
	}

	/**
	 * Should log given message.
	 *
	 * @return void
	 */
	public function testShouldLogToConsoleWithMessage()
	{
		$this->envMock->shouldReceive('get')->once()->with('APP_ENV')->andReturn('testing');

		$errorMessage  = 'post not found!';

		$this->log->shouldReceive('logToConsole')->once()->with('post not found!')->andReturn(null);

		$this->log->fire($errorMessage);
	}

	/**
	 * Should log given message.
	 *
	 * @return void
	 */
	public function testShouldLogToConsoleWithArrayMessage()
	{
		$this->envMock->shouldReceive('get')->once()->with('APP_ENV')->andReturn('testing');

		$errorMessage = ['somemessage' => 'post not found!'];

		$this->log->shouldReceive('logToConsole')->once()->with(['somemessage' => 'post not found!'])->andReturn(null);

		$this->log->fire($errorMessage);
	}

}
