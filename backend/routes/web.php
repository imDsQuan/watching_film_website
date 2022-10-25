<?php

use App\Http\Controllers\ActorController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\LoginController;
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
    Route::get('/', function() {
        return view('pages.home')->with('title', 'Dashboard');
    });
    Route::post('actor/update', [ActorController::class,'update']);
    Route::post('actor/delete/{id}', [ActorController::class, 'destroy']);
    Route::resource('actor', ActorController::class);
    Route::post('get-actor', [ActorController::class, 'getActor']);

    Route::post('genre/update', [GenreController::class,'update']);
    Route::post('genre/delete/{id}', [GenreController::class, 'destroy']);
    Route::resource('genre', GenreController::class);
    Route::post('get-genre', [GenreController::class, 'getGenre']);
});

