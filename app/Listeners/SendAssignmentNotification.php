<?php

namespace App\Listeners;

use App\Events\AssignmentPublished;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendAssignmentNotification implements ShouldQueue
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
    public function handle(AssignmentPublished $event): void
    {
        //
    }
}
