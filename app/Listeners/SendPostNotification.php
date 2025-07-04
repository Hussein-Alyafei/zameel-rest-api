<?php

namespace App\Listeners;

use App\Events\PostPublished;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

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
        Notification::create([
            'title' => 'هناك منشور جديد',
            'content' => is_null($event->post->content) ? 'يتضمن المنشور مرفق.' : Str::limit($event->post->content, 30),
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
                        'title' => 'هناك منشور جديد!!!',
                        'body' => 'انقر للاطلاع على أخر التحديثات',
                    ],
                ],
            ]);
        }
    }
}
