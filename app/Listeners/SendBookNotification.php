<?php

namespace App\Listeners;

use App\Events\BooKPublished;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendBookNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BooKPublished $event): void
    {
        //
    }
}
