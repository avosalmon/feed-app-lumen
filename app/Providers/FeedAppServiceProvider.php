<?php namespace App\Providers;

use DOMDocument;
use Firebase\FirebaseLib;
use Illuminate\Support\ServiceProvider;
use App\Avosalmon\Scraper\BlogScraper;
use App\Avosalmon\Store\Blog\BlogFirebaseRepository;

class FeedAppServiceProvider extends ServiceProvider
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
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerImplementations();
        $this->registerInterfaces();
    }

    /**
     * Register implementations.
     *
     * @return void
     */
    protected function registerImplementations()
    {
        $this->app->bind('App\Avosalmon\Scraper\BlogScraper', function () {
            return new BlogScraper(new DOMDocument);
        });
    }

    /**
     * Register interfaces.
     *
     * @return void
     */
    protected function registerInterfaces()
    {
        $this->app->bind('App\Avosalmon\Store\Blog\BlogRepositoryInterface', function () {
            return new BlogFirebaseRepository(new FirebaseLib(env('FIREBASE_URL')));
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
            'App\Avosalmon\Scraper\BlogScraper',
            'App\Avosalmon\Store\Blog\BlogRepositoryInterface'
        ];
    }
}
