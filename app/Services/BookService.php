<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Author;
use App\Jobs\UpdateAuthorLastBookTitle;

class BookService
{
    /**
     * Create a new book with authors
     */
    public function createBook(array $data): Book
    {
        $book = Book::create([
            'title' => $data['title']
        ]);

        $this->syncAuthors($book, $data['author_ids']);

        UpdateAuthorLastBookTitle::dispatch($book);

        return $book->load('authors');
    }

    /**
     * Update an existing book with authors
     */
    public function updateBook(Book $book, array $data): Book
    {
        $book->update([
            'title' => $data['title']
        ]);

        $this->syncAuthors($book, $data['author_ids']);

        return $book->load('authors');
    }

    /**
     * Delete a book and detach authors
     */
    public function deleteBook(Book $book): void
    {
        $book->authors()->detach();
        $book->delete();
    }

    /**
     * Sync authors relationship for a book
     */
    private function syncAuthors(Book $book, array $authorIds): void
    {
        $book->authors()->sync($authorIds);
    }
}