<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AuthorController extends Controller
{
    const PER_PAGE = 10;

    public function index(Request $request): AnonymousResourceCollection
    {
        $authors = Author::when($request->search, fn($query) => $query->searchByBookTitle($request->search))
            ->with('books')
            ->paginate(self::PER_PAGE);

        return AuthorResource::collection($authors);
    }

    public function show(Author $author): AuthorResource
    {
        $author->load('books');

        return new AuthorResource($author);
    }

}
