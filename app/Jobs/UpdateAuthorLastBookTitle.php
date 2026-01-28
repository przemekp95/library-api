<?php

namespace App\Jobs;

use App\Models\Book;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateAuthorLastBookTitle implements ShouldQueue
{
    use Dispatchable;

    protected $book;

    /**
     * Create a new job instance.
     */
    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->book->authors->each(function ($author) {
            $author->update([
                'last_book_title' => $this->book->title
            ]);
        });
    }
}
