<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

// use Playground\Http\Controllers;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

if (! empty(config('playground.routes.about'))) {
    Route::get('/about', [
        'as' => 'about',
        'middleware' => [
            'web',
        ],
        // 'namespace' => 'Playground\Http\Controllers',
        'uses' => '\Playground\Http\Controllers\IndexController@about',
    ]);
}

if (! empty(config('playground.routes.bootstrap'))) {
    Route::get('/bootstrap', [
        'as' => 'bootstrap',
        'middleware' => [
            'web',
        ],
        // 'namespace' => 'Playground\Http\Controllers',
        'uses' => '\Playground\Http\Controllers\IndexController@bootstrap',
    ]);
}

if (! empty(config('playground.routes.home'))) {
    Route::get('/', [
        'middleware' => [
            'web',
        ],
        // 'namespace' => 'Playground\Http\Controllers',
        'uses' => '\Playground\Http\Controllers\IndexController@home',
    ]);
    Route::get('/home', [
        'as' => 'home',
        'middleware' => [
            'web',
        ],
        // 'namespace' => 'Playground\Http\Controllers',
        'uses' => '\Playground\Http\Controllers\IndexController@home',
    ]);
}

if (! empty(config('playground.routes.dashboard'))) {
    Route::get('/dashboard', [
        'as' => 'dashboard',
        'middleware' => [
            'web',
        ],
        // 'namespace' => 'Playground\Http\Controllers',
        'uses' => '\Playground\Http\Controllers\IndexController@dashboard',
    ]);
}

if (! empty(config('playground.routes.sitemap'))) {
    Route::get('/sitemap', [
        'as' => 'sitemap',
        'middleware' => [
            'web',
        ],
        // 'namespace' => 'Playground\Http\Controllers',
        'uses' => '\Playground\Http\Controllers\IndexController@sitemap',
    ]);
}

if (! empty(config('playground.routes.theme'))) {
    Route::get('/theme', [
        'as' => 'theme',
        'middleware' => [
            'web',
        ],
        // 'namespace' => 'Playground\Http\Controllers',
        'uses' => '\Playground\Http\Controllers\IndexController@theme',
    ]);
}

if (! empty(config('playground.routes.welcome'))) {
    Route::get('/welcome', [
        'as' => 'welcome',
        'middleware' => [
            'web',
        ],
        // 'namespace' => 'Playground\Http\Controllers',
        'uses' => '\Playground\Http\Controllers\IndexController@welcome',
    ]);
}
