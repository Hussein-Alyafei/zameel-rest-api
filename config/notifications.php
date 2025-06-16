<?php

return [

    'default' => env('PUSH_NOTIFICATIONS_CONNECTION', 'null'),

    'connections' => [
        'pusher_beams' => [
            'instance_id' => env('PUSHER_BEAMS_INSTANCE_ID'),
            'key' => env('PUSHER_BEAMS_KEY'),
            'host' => 'https://'.env('PUSHER_BEAMS_INSTANCE_ID').'.pushnotifications.pusher.com/publish_api/v1/instances/'.env('PUSHER_BEAMS_INSTANCE_ID').'/publishes',
        ],
    ],

];
