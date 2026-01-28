<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test GET /api/authors
     */
    public function test_get_authors(): void
    {
        $user = User::factory()->create();
        $authors = Author::factory(5)->create();

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/authors');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'first_name', 'last_name', 'last_book_title', 'created_at', 'updated_at', 'books']
                ],
                'links'
            ]);
    }

    /**
     * Test GET /api/authors with search filter
     */
    public function test_get_authors_with_search_filter(): void
    {
        $user = User::factory()->create();
        
        // Create authors and books
        $author1 = Author::factory()->create(['first_name' => 'John', 'last_name' => 'Doe']);
        $author2 = Author::factory()->create(['first_name' => 'Jane', 'last_name' => 'Smith']);
        
        $book1 = Book::factory()->create(['title' => 'Programming Guide']);
        $book2 = Book::factory()->create(['title' => 'Cooking Book']);
        
        // Associate authors with books
        $author1->books()->attach($book1);
        $author2->books()->attach($book2);

        // Test search by book title
        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/authors?search=Programming');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.first_name', 'John')
            ->assertJsonPath('data.0.last_name', 'Doe');
    }

    /**
     * Test GET /api/authors with search filter - no results
     */
    public function test_get_authors_with_search_filter_no_results(): void
    {
        $user = User::factory()->create();
        
        // Create authors and books
        $author = Author::factory()->create(['first_name' => 'John', 'last_name' => 'Doe']);
        $book = Book::factory()->create(['title' => 'Programming Guide']);
        $author->books()->attach($book);

        // Test search that returns no results
        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/authors?search=Nonexistent');

        $response->assertStatus(200)
            ->assertJsonCount(0, 'data');
    }

    /**
     * Test GET /api/authors/{id}
     */
    public function test_get_author_by_id(): void
    {
        $user = User::factory()->create();
        $author = Author::factory()->create(['first_name' => 'Test', 'last_name' => 'Author']);
        $book = Book::factory()->create(['title' => 'Test Book']);
        $author->books()->attach($book);

        $response = $this->actingAs($user, 'sanctum')->getJson("/api/authors/{$author->id}");

        $response->assertStatus(200)
            ->assertJson([
                'id' => $author->id,
                'first_name' => 'Test',
                'last_name' => 'Author',
                'books' => [
                    [
                        'id' => $book->id,
                        'title' => 'Test Book'
                    ]
                ]
            ]);
    }

    /**
     * Test GET /api/authors/{id} - author not found
     */
    public function test_get_author_by_id_not_found(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/authors/999');

        $response->assertStatus(404);
    }
}