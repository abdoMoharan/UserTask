<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tag\TagController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\Stats\StatsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('verifyCode', [AuthController::class, 'verifyCode']);



Route::middleware(['auth:sanctum'])->group(function () {
Route::controller(TagController::class)->group(function () {
    Route::get('tags', 'index');
    Route::get('tags/show/{id}', 'show');
    Route::post('tags/store', 'store');
    Route::put('tags/update/{id}', 'update');
    Route::delete('tags/delete/{id}', 'destroy');
});
    Route::controller(PostController::class)->group(function () {
        Route::put('posts/update/{id}', 'update');
        Route::get('posts/{id}', 'show');
        Route::get('/posts/restore/{id}', 'restore');
        Route::delete('posts/delete/{id}', 'destroy');
        Route::post('posts/store', 'store');
        Route::get('posts', 'index');
        Route::get('showAllPostDeleted', 'showAllPostDeleted');
    });

    Route::controller(StatsController::class)->group(function(){
        Route::get('stats/countUsers', 'countUsers');
        Route::get('stats/countPosts', 'countPosts');
        Route::get('stats/countPostUser', 'countPostUser');
    });
});




