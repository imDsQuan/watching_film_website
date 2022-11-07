<?php

use App\Http\Controllers\ActorController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PosterController;
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

Route::post('login.blade.php', [ApiController::class, 'login']);
Route::post('register', [ApiController::class, 'register']);

Route::group(['middleware' => ['api', 'CORS']], function () {
    Route::get('logout', [ApiController::class, 'logout']);
    Route::get('user', [ApiController::class, 'getAuthUser']);
});

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
    Route::get('/{slug}', [MovieController::class, 'getBySlug']);

});
