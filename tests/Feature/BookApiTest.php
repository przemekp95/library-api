<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test POST /api/books
     */
    public function test_create_book(): void
    {
        $authors = Author::factory(3)->create();

        $response = $this->postJson('/api/books', [
            'title' => 'Test Book',
            'author_ids' => $authors->pluck('id')->toArray()
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'title' => 'Test Book'
            ]);

        $this->assertDatabaseHas('books', [
            'title' => 'Test Book'
        ]);

        $this->assertDatabaseHas('author_book', [
            'author_id' => $authors->first()->id,
            'book_id' => 1
        ]);
    }

    /**
     * Test DELETE /api/books/{id}
     */
    public function test_delete_book(): void
    {
        $authors = Author::factory(2)->create();
        $book = Book::factory()->create();
        $book->authors()->attach($authors);

        $response = $this->deleteJson("/api/books/{$book->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('books', [
            'id' => $book->id
        ]);

        $this->assertDatabaseMissing('author_book', [
            'book_id' => $book->id
        ]);
    }
}
