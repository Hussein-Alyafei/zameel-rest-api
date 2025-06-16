<?php

namespace App\Listeners;

use App\Events\AssignmentPublished;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

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
        Notification::create([
            'title' => 'هناك تكليف جديد',
            'content' => Str::limit($event->assignment->title, 30),
            'interests' => ['debug-all'],
        ]);

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
