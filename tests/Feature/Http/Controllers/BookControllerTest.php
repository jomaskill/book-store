<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(User::factory()->create());
    }

    public function test_it_should_index_books(): void
    {
        $books = Book::factory(10)->create();

        $this->getJson('api/book')
            ->assertSuccessful()
            ->assertJsonPath('data', $books->map(fn(Book $book) => [
                'id'         => $book->id,
                'name'       => $book->name,
                'isbn'       => $book->isbn,
                'value'      => $book->value,
                'created_at' => $book->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $book->updated_at->format('Y-m-d H:i:s')
            ])->toArray());
    }

    public function test_it_should_create_a_book(): void
    {
        $response = $this->postJson('api/book', [
            'name'       => 'random name',
            'isbn'       => 12345678,
            'value'      => 39.90,
        ])
            ->assertCreated()
            ->assertJsonFragment(json_decode((New BookResource(Book::first()))->toJson(), true));

        $this->assertDatabaseHas(Book::class, json_decode($response->baseResponse->content(), true)['data']);
    }

    public function test_it_should_show_a_book(): void
    {
        $book = Book::factory()->create();

        $this->getJson("api/book/$book->id")
            ->assertSuccessful()
            ->assertJsonFragment(json_decode((New BookResource($book))->toJson(), true));
    }

    public function test_it_should_update_a_book(): void
    {
        $book = Book::factory()->create();

        $updateData = [
            'name'  => 'random name',
            'isbn'  => 12345678,
            'value' => 39.59,
        ];

        $this->putJson("api/book/$book->id", $updateData)
            ->assertSuccessful()
            ->assertJsonFragment(json_decode((New BookResource($book->refresh()))->toJson(), true));

        $this->assertDatabaseHas(Book::class, [
            ...$book->toArray(),
            ...$updateData
        ]);

    }

    public function test_it_should_delete_a_book(): void
    {
        $books = Book::factory(2)->create();
        $deletedbook = $books->first();

        $this->deleteJson("api/book/$deletedbook->id")
            ->assertNoContent();

        $this->assertSoftDeleted(Book::class, $deletedbook->toArray());
        $this->assertNotSoftDeleted(Book::class, $books->last()->toArray());
    }
}
