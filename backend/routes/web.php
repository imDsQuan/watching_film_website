<?php

use App\Http\Controllers\ActorController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\NotificaitionController;
use App\Http\Controllers\PackController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TvShowController;
use App\Http\Controllers\UserController;
use App\Repositories\PackRepository;
use Illuminate\Support\Facades\Route;

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


Route::get('login', [LoginController::class, 'getLogin']);
Route::get('logout', [LoginController::class, 'getLogout']);
Route::post('login', [LoginController::class, 'postLogin']);

Route::group(['middleware' => ['CheckAdminLogin', 'CORS']], function() {
    Route::resource('/', DashboardController::class);
    Route::post('actor/update', [ActorController::class,'update']);
    Route::post('actor/delete/{id}', [ActorController::class, 'destroy']);
    Route::post('actor/search', [ActorController::class,'search']);
    Route::resource('actor', ActorController::class);

    Route::post('pack/update', [PackController::class,'update']);
    Route::post('pack/delete/{id}', [PackController::class, 'destroy']);
    Route::resource('pack', PackController::class);
    Route::post('get-pack', [PackController::class, 'getGenre']);
    Route::get('/pack/{id}/up', [PackController::class, 'upAction']);
    Route::get('/pack/{id}/down', [PackController::class, 'downAction']);


    Route::post('genre/update', [GenreController::class,'update']);
    Route::post('genre/delete/{id}', [GenreController::class, 'destroy']);
    Route::resource('genre', GenreController::class);
    Route::post('get-genre', [GenreController::class, 'getGenre']);
    Route::get('/genre/{id}/up', [GenreController::class, 'upAction']);
    Route::get('/genre/{id}/down', [GenreController::class, 'downAction']);

    Route::get('movie/{slug}/trailer', [MovieController::class,'indexTrailer']);
    Route::post('movie/{slug}/trailer', [MovieController::class,'storeTrailer']);

    Route::get('/movie/{slug}/cast', [MovieController::class, 'indexCast']);
    Route::post('movie/{slug}/cast', [MovieController::class, 'storeCast']);
    Route::get('movie/{slug}/cast/{roleId}/edit', [MovieController::class, 'editCast']);
    Route::post('movie/{slug}/cast/{roleId}/update', [MovieController::class, 'updateCast']);
    Route::post('movie/{slug}/cast/{roleId}/delete', [MovieController::class, 'deleteCast']);
    Route::get('movie/{slug}/cast/{roleId}/up', [MovieController::class, 'upCast']);
    Route::get('movie/{slug}/cast/{roleId}/down', [MovieController::class, 'downCast']);

    Route::post('movie/{movieId}/source/{sourceId}/delete', [MovieController::class, 'destroySource']);
    Route::get('movie/{movieId}/source/{sourceId}/edit', [MovieController::class, 'editSource']);
    Route::post('movie/{movieId}/source/{sourceId}', [MovieController::class, 'updateSource']);
    Route::post('movie/source/upload', [MovieController::class,'uploadSourceFile']);
    Route::get('movie/{movieId}/source/create', [MovieController::class, 'createSource']);
    Route::get('movie/{slug}/source', [MovieController::class, 'indexSource']);
    Route::post('movie/{slug}/source', [MovieController::class,'storeSource']);

    Route::post('movie/update', [MovieController::class,'update']);
    Route::post('movie/delete/{id}', [MovieController::class, 'destroy']);
    Route::post('movie/search', [MovieController::class,'search']);
    Route::resource('movie', MovieController::class);

    Route::get('tvShow/{slug}/trailer', [TvShowController::class,'indexTrailer']);
    Route::post('tvShow/{slug}/trailer', [TvShowController::class,'storeTrailer']);

    Route::get('/tvShow/{slug}/cast', [TvShowController::class, 'indexCast']);
    Route::post('tvShow/{slug}/cast', [TvShowController::class, 'storeCast']);
    Route::get('tvShow/{slug}/cast/{roleId}/edit', [TvShowController::class, 'editCast']);
    Route::post('tvShow/{slug}/cast/{roleId}/update', [TvShowController::class, 'updateCast']);
    Route::post('tvShow/{slug}/cast/{roleId}/delete', [TvShowController::class, 'deleteCast']);
    Route::get('tvShow/{slug}/cast/{roleId}/up', [TvShowController::class, 'upCast']);
    Route::get('tvShow/{slug}/cast/{roleId}/down', [TvShowController::class, 'downCast']);

    Route::get('/tvShow/{slug}/season/{seasonId}/episode/create', [TvShowController::class, 'createEpisode']);
    Route::post('/tvShow/{slug}/season/{seasonId}/episode/', [TvShowController::class, 'storeEpisode']);
    Route::get('/tvShow/{slug}/season/{seasonId}/episode/{episodeId}/edit', [TvShowController::class, 'editEpisode']);
    Route::post('/tvShow/{slug}/season/{seasonId}/episode/{episodeId}/update', [TvShowController::class, 'updateEpisode']);
    Route::get('/tvShow/{slug}/season/{seasonId}/episode/{episodeId}/up', [TvShowController::class, 'upEpisode']);
    Route::get('/tvShow/{slug}/season/{seasonId}/episode/{episodeId}/down', [TvShowController::class, 'downEpisode']);


    Route::get('/tvShow/{slug}/season/{seasonId}/edit', [TvShowController::class, 'editSeason']);
    Route::post('/tvShow/{slug}/season/{seasonId}/update', [TvShowController::class, 'updateSeason']);
    Route::post('/tvShow/{slug}/season/{seasonId}/delete', [TvShowController::class, 'deleteSeason']);
    Route::get('/tvShow/{slug}/season/{seasonId}/up', [TvShowController::class, 'upSeason']);
    Route::get('/tvShow/{slug}/season/{seasonId}/down', [TvShowController::class, 'downSeason']);
    Route::post('/tvShow/{slug}/season', [TvShowController::class, 'storeSeason']);
    Route::get('/tvShow/{slug}/season', [TvShowController::class, 'indexSeason']);


    Route::post('tvShow/{slug}/season/{seasonId}/episode/{episodeId}/source/{sourceId}/delete', [TvShowController::class, 'destroySource']);
    Route::get('tvShow/{slug}/season/{seasonId}/episode/{episodeId}/source/{sourceId}/edit', [TvShowController::class, 'editSource']);
    Route::post('tvShow/{slug}/season/{seasonId}/episode/{episodeId}/source/{sourceId}', [TvShowController::class, 'updateSource']);
    Route::post('tvShow/source/upload', [TvShowController::class,'uploadSourceFile']);
    Route::get('tvShow/{slug}/season/{seasonId}/episode/{episodeId}/source/create', [TvShowController::class, 'createSource']);
    Route::get('tvShow/{slug}/season/{seasonId}/episode/{episodeId}/source', [TvShowController::class, 'indexSource']);
    Route::post('tvShow/{slug}/season/{seasonId}/episode/{episodeId}/source', [TvShowController::class,'storeSource']);




    Route::post('tvShow/update', [TvShowController::class,'update']);
    Route::post('tvShow/delete/{id}', [TvShowController::class, 'destroy']);
    Route::post('tvShow/search', [TvShowController::class,'search']);
    Route::resource('tvShow', TvShowController::class);

    Route::resource('user', UserController::class);

    Route::resource('payment', PaymentController::class);

    Route::resource('notification', NotificaitionController::class);


});

Route::post('movie/get-movie', [MovieController::class, 'getMovie']);
Route::post('tvShow/getTvShow', [TvShowController::class, 'getTvShow']);
Route::post('actor/get-actor', [ActorController::class, 'getActor']);

Route::post('/tvShow/{slug}/season/{seasonId}/episode/{episodeId}/delete', [TvShowController::class, 'deleteEpisode']);


Route::post('movie/fake-source', [MovieController::class, 'fakeSource']);
Route::get('tvshow/fake-tvshow', [TvShowController::class, 'fakeTvShow']);


