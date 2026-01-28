<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\AuthorController;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('books', BookController::class);
});

Route::apiResource('authors', AuthorController::class);
