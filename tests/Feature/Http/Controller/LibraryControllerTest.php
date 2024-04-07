<?php

namespace Tests\Feature\Http\Controller;

use App\Models\Book;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LibraryControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(User::factory()->create());
    }

    public function test_it_should_increase_books_of_a_store_if_already_has_a_relationship(): void
    {
        $store = Store::factory(Store::class)->create();
        $book  = Book::factory(Book::class)->create();
        $store->books()->attach($book->id, ['quantity' => 10]);

        $this->postJson('api/library/add-book-in-store', [
            'book_id'  => $book->id,
            'store_id' => $store->id,
            'quantity' => 10
        ])->assertSuccessful();

        $this->assertDatabaseHas('book_store', [
            'book_id'  => $book->id,
            'store_id' => $store->id,
            'quantity' => 20
        ]);
    }

    public function test_it_should_add_books_to_a_store(): void
    {
        $store = Store::factory(Store::class)->create();
        $book  = Book::factory(Book::class)->create();

        $this->postJson('api/library/add-book-in-store', [
            'book_id'  => $book->id,
            'store_id' => $store->id,
            'quantity' => 10
        ])->assertSuccessful();

        $this->assertDatabaseHas('book_store', [
            'book_id'  => $book->id,
            'store_id' => $store->id,
            'quantity' => 10
        ]);
    }

    public function test_it_should_remove_book_in_store(): void
    {
        $store = Store::factory(Store::class)->create();
        $book  = Book::factory(Book::class)->create();
        $store->books()->attach($book->id, ['quantity' => 10]);

        $this->postJson('api/library/remove-book-in-store', [
            'book_id'  => $book->id,
            'store_id' => $store->id,
            'quantity' => 9
        ])->assertSuccessful();

        $this->assertDatabaseHas('book_store', [
            'book_id'  => $book->id,
            'store_id' => $store->id,
            'quantity' => 1
        ]);
    }
}
