<?php

namespace App\Jobs;

use App\Models\Book;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class UpdateLastBookTitle implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Book $book
    ){}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->book->load('authors');

        $this->book->authors->each(function ($author) {
            $author->last_book_title = $this->book->title;
            $author->save();
        });
    }
}
