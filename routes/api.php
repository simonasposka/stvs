<?php

use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PublicArticlesController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SeedController;
use App\Http\Controllers\TeamArticlesController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\TeamUserArticlesController;
use App\Http\Controllers\TeamUsersController;
use App\Http\Controllers\UsersController;
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

Route::post('register', [RegisterController::class, 'store']);

Route::group(['prefix' => 'auth'], static function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('refresh', [LoginController::class, 'refresh']);
});

Route::group(['middleware' => 'jwt'], static function() { // required JWT bearer token (only logged in users can access)
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
        Route::get('{teamId}/users/{userId}/articles', [TeamUserArticlesController::class, 'show']); // list articles user wrote for given team
    });

    Route::group(['prefix' => 'articles'], static function () {
        Route::get('', [ArticlesController::class, 'index']);
        Route::get('{articleId}', [ArticlesController::class, 'show']);
        Route::post('', [ArticlesController::class, 'store']);
        Route::patch('{articleId}', [ArticlesController::class, 'update']);
        Route::delete('{articleId}', [ArticlesController::class, 'destroy']);
    });

    // Admin only
    Route::group(['prefix' => 'users', 'middleware' => 'admin'], static function () { // Requires claim {role:admin}
        Route::get('', [UsersController::class, 'index']);
        Route::get('{userId}', [UsersController::class, 'show']);
        Route::patch('{userId}', [UsersController::class, 'update']);
        Route::delete('{userId}', [UsersController::class, 'destroy']);
    });
});

// Public
Route::get('/public/articles', [PublicArticlesController::class, 'index']);

Route::post('seed', [SeedController::class, 'seed']);
Route::delete('seed', [SeedController::class, 'clear']);
