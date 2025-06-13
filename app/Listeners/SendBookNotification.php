<?php

namespace App\Listeners;

use App\Events\BooKPublished;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;

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
        Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.config('brodcasting.pusher.beams.key'),
        ])->post(config('brodcasting.pusher.beams.host'), [
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
