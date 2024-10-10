<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\PostController;
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
    Route::post('posts/{id}/like', [PostController::class, 'like']);
    Route::post('posts/{id}/comment', [PostController::class, 'createComment']);
    Route::get('posts/comment/{id}', [PostController::class, 'getComment']);
    Route::delete('posts/comment/{id}', [PostController::class, 'deleteComment']);
    Route::post('posts/comment/{id}/like', [PostController::class, 'likeComment']);
});
