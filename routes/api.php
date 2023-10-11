<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForumCommentController;
use App\Http\Controllers\ForumController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;

Route::group(['middleware' => 'api'], function ($router) {

    Route::prefix('auth')->group(function () {
        Route::post('register', [RegisterController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('me', [AuthController::class, 'me']);
    });

    Route::get('/forums/tag/{tag}', [ForumController::class, 'filterTag']);

    Route::get('/user/@{username}', [UserController::class, 'show']);
    Route::get('/user/@{username}/activity', [UserController::class, 'getActivity']);


    Route::apiResource('forums', ForumController::class);
    Route::apiResource('forums.comments', ForumCommentController::class);
});
