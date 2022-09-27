<?php

use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TeamsController;
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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [RegisterController::class, 'store']);


Route::group(['prefix' => 'teams'], static function () {
    Route::get('', [TeamsController::class, 'index']);
});

Route::group(['prefix' => 'blogs'], static function () {
    Route::get('', [BlogsController::class, 'index']);
    Route::get('{blog}', [BlogsController::class, 'show']);
});

Route::group(['prefix' => 'articles'], static function () {
    Route::get('', [ArticlesController::class, 'index']);
    Route::get('{article}', [ArticlesController::class, 'show']);
});



