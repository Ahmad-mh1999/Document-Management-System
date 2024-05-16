<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\DocumentController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
    ], function ($router) {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    });
    
    
    Route::group([
        'middleware' => 'api',
    ], function ($router) {

        Route::get('/users', [UserController::class, 'index']);

        Route::get('/documents', [DocumentController::class, 'index']);
        Route::post('/document', [DocumentController::class, 'store']);
        Route::get('/document/{id}', [DocumentController::class, 'show']);
        Route::put('/document/{id}', [DocumentController::class, 'update']);
        Route::delete('/document/{id}', [DocumentController::class, 'destroy']);
    
        Route::post('/documents/{documentId}/comments', [CommentController::class, 'store']);
        Route::get('/comments/{comment}', [CommentController::class, 'show']);
        Route::put('/comments/{comment}', [CommentController::class, 'update']);
        Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);
    });