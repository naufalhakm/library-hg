<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\CategoryController;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('jwt:auth')->group(function () {
    Route::apiResource('categories', CategoryController::class);

    Route::apiResource('books', BookController::class);

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'create']);
    Route::get('/categories/{id}', [CategoryController::class, 'detail']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

    Route::get('/books', [BookController::class, 'index']);
    Route::post('/books', [BookController::class, 'create']);
    Route::get('/books/{id}', [BookController::class, 'detail']);
    Route::put('/books/{id}', [BookController::class, 'update']);
    Route::delete('/books/{id}', [BookController::class, 'destroy']);


    Route::post('/users/borrow', [BorrowController::class, 'borrowBook']);
    Route::post('/users/{id}/return', [BorrowController::class, 'returnBook']);
    Route::get('/users/{userID}/borrow', [BorrowController::class, 'borrowedBooks']);
});
