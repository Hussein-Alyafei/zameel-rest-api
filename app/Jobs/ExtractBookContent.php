<?php

namespace App\Jobs;

use App\Models\Book;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

class ExtractBookContent implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private Book $book)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->book->content = PDFToText(Storage::url($this->book->path));
        $this->book->save();
    }
}
