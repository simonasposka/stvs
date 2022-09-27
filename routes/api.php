<?php

use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TeamArticlesController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\TeamUsersController;
use App\Http\Controllers\UsersController;
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
    Route::get('{teamId}', [TeamsController::class, 'show']);
    Route::post('', [TeamsController::class, 'store']);
    Route::patch('{teamId}', [TeamsController::class, 'update']);
    Route::delete('{teamId}', [TeamsController::class, 'destroy']);

    Route::get('{teamId}/users', [TeamUsersController::class, 'show']); // list team's users
    Route::put('{teamId}/users', [TeamUsersController::class, 'update']); // add user to team
    Route::delete('{teamId}/users/{userId}', [TeamUsersController::class, 'destroy']); // remove user from team

    Route::get('{teamId}/articles', [TeamArticlesController::class, 'show']); // list team's articles
});

Route::group(['prefix' => 'articles'], static function () {
    Route::get('', [ArticlesController::class, 'index']);
    Route::get('{articleId}', [ArticlesController::class, 'show']);
    Route::post('', [ArticlesController::class, 'store']);
    Route::patch('{articleId}', [ArticlesController::class, 'update']);
    Route::delete('{articleId}', [ArticlesController::class, 'destroy']);
});

// Admin only
Route::group(['prefix' => 'users'], static function () {
    Route::get('', [UsersController::class, 'index']);
    Route::delete('{userId}', [UsersController::class, 'destroy']);
});


