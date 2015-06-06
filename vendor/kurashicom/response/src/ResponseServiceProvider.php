<?php namespace Kurashicom\Response;

use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Http\ResponseFactory;
use Kurashicom\Response\Actions\Logger;
use Kurashicom\Response\Proxies\DotEnvProxy;
use Kurashicom\Response\Proxies\MonologProxy;

class ResponseServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerClassBindings();
        $this->registerExceptionHandlers();
    }

    /**
     * Register class bindings.
     *
     * @return void
     */
    public function registerClassBindings()
    {
        $this->app->bind('Kurashicom\Response\Actions\Logger', function () {
            return new Logger(
                new MonologProxy(),
                new DotEnvProxy(),
                $this->app['request']
            );
        });

        $this->app->bind('Kurashicom\Response\ResponseHandler', function () {
            return new ResponseHandler(
                new ResponseFactory($this->app),
                $this->app['view'],
                [], //successActions
                [$this->app->make('Kurashicom\Response\Actions\Logger')] //errorActions
            );
        });
    }

    /**
     * Register error handlers.
     *
     * @return void
     */
    public function registerExceptionHandlers()
    {
        $this->app->bind('Illuminate\Contracts\Debug\ExceptionHandler', function () {
            return new ResponseExceptionHandler(
                $this->app->make('Kurashicom\Response\ResponseHandler')
            );
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'Kurashicom\Response\Actions\Logger',
            'Kurashicom\Response\ResponseHandler'
        ];
    }
}
