<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => '/auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/check', [AuthController::class, 'check'])->middleware('auth:sanctum');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});


Route::middleware('auth:sanctum')->group(function () {

    Route::group(['prefix' => '/user'], function () {
        Route::get('/posts', [PostController::class, 'getUserPosts']);
    });

    Route::group(['prefix' => '/posts'], function () {
        Route::get('/', [PostController::class, 'getPosts']);
        Route::get('/{id}', [PostController::class, 'getPost']);
        Route::post('/', [PostController::class, 'createPost']);
        Route::post('/{id}', [PostController::class, 'updatePost']);
        Route::delete('/{id}', [PostController::class, 'deletePost']);

        Route::post('/{id}/comments', [PostCommentController::class, 'addComment']);
        Route::delete('/{id}/comments/{commentId}', [PostCommentController::class, 'deleteComment']);
    });

    Route::group(['prefix' => '/categories'], function () {
        Route::get('/', [CategoryController::class, 'getCategories']);
    });
});

