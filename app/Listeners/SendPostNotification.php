<?php

namespace App\Listeners;

use App\Events\PostPublished;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;

class SendPostNotification implements ShouldQueue
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
    public function handle(PostPublished $event): void
    {
        Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.config('broadcasting.connections.pusher.beams.key'),
        ])->post(config('broadcasting.connections.pusher.beams.host'), [
            'interests' => ['debug-all'],
            'fcm' => [
                'notification' => [
                    'title' => 'هناك منشور جديد!!!',
                    'body' => 'انقر للاطلاع على أخر التحديثات',
                ],
            ],
        ]);
    }
}
