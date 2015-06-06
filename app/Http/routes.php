<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

$app->get('/', function() use ($app) {
    return $app->welcome();
});

$app->group(['prefix' => 'blog'], function($app)
{
    $app->get('/',     ['as' => 'blog.index', 'uses' => 'App\Http\Controllers\BlogController@index']);
    $app->get('/{id}', ['as' => 'blog.show',  'uses' => 'App\Http\Controllers\BlogController@show']);
});

$app->group(['prefix' => 'instagram'], function($app)
{
    $app->get('/',     ['as' => 'instagram.index', 'uses' => 'App\Http\Controllers\InstagramController@index']);
    $app->post('/',    ['as' => 'instagram.store', 'uses' => 'App\Http\Controllers\InstagramController@store']);
    $app->get('/{id}', ['as' => 'instagram.show',  'uses' => 'App\Http\Controllers\InstagramController@show']);
});

$app->group(['prefix' => 'twitter'], function($app)
{
    $app->get('/',     ['as' => 'twitter.index', 'uses' => 'App\Http\Controllers\TwitterController@index']);
    $app->post('/',    ['as' => 'twitter.store', 'uses' => 'App\Http\Controllers\TwitterController@store']);
    $app->get('/{id}', ['as' => 'twitter.show',  'uses' => 'App\Http\Controllers\TwitterController@show']);
});
