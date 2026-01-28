<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'status' => 'ok',
        'name' => 'Books & Authors API',
        'version' => '1.0.0',
        'description' => 'Recruitment task - Laravel REST API for managing books and authors',
        'endpoints' => [
            'GET /api/books' => 'List all books',
            'POST /api/books' => 'Create new book',
            'GET /api/books/{id}' => 'Get book by ID',
            'PUT /api/books/{id}' => 'Update book',
            'DELETE /api/books/{id}' => 'Delete book',
            'GET /api/authors' => 'List all authors',
            'POST /api/authors' => 'Create new author',
            'GET /api/authors/{id}' => 'Get author by ID',
            'PUT /api/authors/{id}' => 'Update author',
            'DELETE /api/authors/{id}' => 'Delete author'
        ]
    ]);
});
