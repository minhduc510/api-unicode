<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\FollowController;
use App\Http\Controllers\Api\CommentController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'prefix' => 'auth'
], function ($router) {
    // Auth
    Route::get('profile', [AuthController::class, 'me'])->middleware('jwt.custom');
    Route::put('profile', [AuthController::class, 'updateMe'])->middleware('jwt.custom');
    Route::patch('profile', [AuthController::class, 'updateMe'])->middleware('jwt.custom');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('jwt.custom');
    Route::post('refresh', [AuthController::class, 'refresh']);
});

Route::group([
    'middleware' => ['jwt.custom', 'decode_token']
], function () {
    // POST
    Route::apiResource('posts', PostController::class);
    Route::get('posts/user/{id}', [PostController::class, 'getPostsByUser']);
    Route::get('posts/like/list', [PostController::class, 'getListLike']);
    Route::post('posts/{id}/like', [PostController::class, 'like']);

    Route::get('posts/comment/{id}', [PostController::class, 'getComment']);
    Route::put('posts/comment/{id}', [PostController::class, 'updateComment']);
    Route::patch('posts/comment/{id}', [PostController::class, 'updateComment']);
    Route::post('posts/{id}/comment', [PostController::class, 'createComment']);
    Route::post('posts/comment/{id}/like', [PostController::class, 'likeComment']);
    Route::delete('posts/comment/{id}', [PostController::class, 'deleteComment']);

    Route::post('posts/saved', [PostController::class, 'getSaved']);
    Route::get('posts/saved/list', [PostController::class, 'getListSaved']);
    Route::post('posts/{id}/saved', [PostController::class, 'saved']);

    // Follow
    Route::get('follows', [FollowController::class, 'getAll']);
    Route::post('follows/{user_id}', [FollowController::class, 'follow']);

    // User
    Route::apiResource('users', UserController::class);
});
