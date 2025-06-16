<?php

namespace App\Listeners;

use App\Events\BookPublished;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

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
    public function handle(BookPublished $event): void
    {
        Notification::create([
            'title' => 'هناك كتاب جديد',
            'content' => Str::limit($event->book->name, 30),
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
                        'title' => 'هناك كتاب جديد!!!',
                        'body' => 'انقر للاطلاع على أخر التحديثات',
                    ],
                ],
            ]);
        }
    }
}
