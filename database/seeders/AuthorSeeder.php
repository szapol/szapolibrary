<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::factory()
            ->has(Author::factory(rand(1,3))
                ->has(Book::factory(rand(1,3))))
            ->count(10)
            ->create();
    }
}
