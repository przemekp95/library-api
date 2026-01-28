<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SanctumAuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test guest access to POST /api/books returns 401
     */
    public function test_guest_cannot_create_book(): void
    {
        $response = $this->postJson('/api/books', [
            'title' => 'Test Book',
            'author_ids' => []
        ]);

        $response->assertStatus(401);
    }

    /**
     * Test authenticated user can create book
     */
    public function test_authenticated_user_can_create_book(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/books', [
            'title' => 'Test Book',
            'author_ids' => []
        ]);

        $response->assertStatus(201);
    }
}
