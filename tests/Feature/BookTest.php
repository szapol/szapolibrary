<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_book(): void
    {
        $user = User::factory()->create();
        $authors = Author::factory(3)->create();

        $data = Book::factory()->make()->toArray();
        $data['authors'] = $authors->pluck('id')->toArray();

        $response = $this->actingAs($user)
            ->post('/api/books', $data);

        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('books', [
            'title' => $data['title']
        ]);
    }

    public function test_unauthorized_user_cannot_create_book(): void
    {
        $data = Book::factory()->make()->toArray();
        $response = $this->postJson('/api/books', $data);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_user_can_delete_book(): void
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $response = $this->actingAs($user)
            ->delete("/api/books/{$book->id}");

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

    public function test_unauthorized_user_cannot_delete_book(): void
    {
        $book = Book::factory()->create();
        $response =$this->deleteJson("/api/books/{$book->id}");

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
