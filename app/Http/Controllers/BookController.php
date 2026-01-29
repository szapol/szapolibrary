<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Jobs\UpdateLastBookTitle;
use App\Models\Book;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class BookController extends Controller
{
    const PER_PAGE = 10;

    public function index(): AnonymousResourceCollection
    {
        $books = Book::with('authors')->paginate(self::PER_PAGE);

        return BookResource::collection($books);
    }

    public function show(Book $book): BookResource
    {
        $book->load('authors');

        return new BookResource($book);
    }

    public function store(StoreBookRequest $request): BookResource
    {
        $book = Book::create($request->validated());
        $book->authors()->attach($request->authors);

        return new BookResource($book->load('authors'));
    }

    public function update(UpdateBookRequest $request, Book $book): BookResource
    {
        $data = $request->validate($request->rules());
        $book->update($data);

        if ($book->authors()) {
            $book->authors()->sync($request->authors);
        }

        return new BookResource($book->load('authors'));
    }

    public function destroy(Book $book): Response
    {
        $book->delete();

        return response()->noContent();
    }
}
