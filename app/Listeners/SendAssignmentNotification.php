<?php

namespace App\Listeners;

use App\Events\AssignmentPublished;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;

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
        if (config('notifications.default') === 'pusher_beams') {
            Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.config('notifications.connections.pusher_beams.key'),
            ])->post(config('notifications.connections.pusher_beams.host'), [
                'interests' => ['debug-all'],
                'fcm' => [
                    'notification' => [
                        'title' => 'هناك تكليف جديد!!!',
                        'body' => 'انقر للاطلاع على أخر التحديثات',
                    ],
                ],
            ]);
        }
    }
}
