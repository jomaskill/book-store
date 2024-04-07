<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class BookController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return BookResource::collection(Book::all());
    }

    public function store(BookRequest $request): JsonResource
    {
        $book = Book::create($request->validated());

        return new BookResource($book);
    }

    public function show(Book $book): JsonResource
    {
        return new BookResource($book);
    }

    public function update(BookRequest $request, Book $book): JsonResource
    {
        $book->update($request->validated());

        return new BookResource($book);
    }

    public function destroy(Book $book): Response
    {
        $book->delete();

        return response()->noContent();
    }
}
