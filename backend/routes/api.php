<?php

use App\Http\Controllers\ActorController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PosterController;
use App\Http\Controllers\TvShowController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::group(['middleware' => [ 'CORS']], function ($router) {
    Route::post('login', [ApiController::class, 'login']);
    Route::post('register', [ApiController::class, 'register']);
    Route::get('logout', [ApiController::class, 'logout']);
    Route::get('user', [ApiController::class, 'getAuthUser']);
});

Route::group(['middleware' => ['CORS']], function() {
    Route::group(['prefix' => 'poster'], function() {
        Route::get('/random', [PosterController::class, 'getRandom']);
        Route::get('/getNewRelease', [PosterController::class, 'getNewRelease']);
        Route::get('/genre/{genre}',[PosterController::class, 'getByGenre']);
    });

    Route::group(['prefix' => 'actor'], function() {
        Route::get('/popular', [ActorController::class, 'getPopular']);
    });

    Route::group(['prefix' => 'movie'], function() {
        Route::get('/all', [MovieController::class, 'getAll']);
        Route::get('/getMovie', [MovieController::class, 'getMovie']);
        Route::get('/{slug}/genres', [MovieController::class, 'getGenresBySlug']);
        Route::get('/{slug}/cast', [MovieController::class, 'getCastBySlug']);
        Route::get('/{slug}/similar', [MovieController::class, 'getSimilarBySlug']);
        Route::get('/{slug}/source', [MovieController::class, 'getSourceBySlug']);
        Route::get('/{slug}', [MovieController::class, 'getBySlug']);
    });

    Route::group(['prefix' => 'tvshow'], function() {
        Route::get('/fake-actor', [TvShowController::class, 'fakeActor']);
        Route::get('/fake-source', [TvShowController::class,'fakeSourceTV']);
        Route::get('/all', [TvShowController::class, 'getAll']);
        Route::get('/getMovie', [TvShowController::class, 'getTvShow']);
        Route::get('/{slug}/episode/{episodeId}/source', [TvShowController::class, 'getSourceBySlug']);
        Route::get('/{slug}/genres', [TvShowController::class, 'getGenresBySlug']);
        Route::get('/{slug}/cast', [TvShowController::class, 'getCastBySlug']);
        Route::get('/{slug}/similar', [TvShowController::class, 'getSimilarBySlug']);
        Route::get('/{slug}/season' ,[TvShowController::class, 'getSeasonBySlug']);
        Route::get('/{slug}', [TvShowController::class, 'getBySlug']);
    });
});
