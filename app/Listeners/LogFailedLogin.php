<?php

namespace App\Listeners;

use App\Services\ActivityLogger;
use Illuminate\Auth\Events\Failed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Str;

class LogFailedLogin
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
    public function handle(Failed $event): void
    {
        if($event->user){
            ActivityLogger::log(
            title: 'Failed login attempt',
            type: 'security',
            extras:[       
            'user_id' => $event->user->id,
            'data' => $event->credentials['email'] ?? 'Unknown',
            'browser' => request()->userAgent(),
            'session_id' => \Illuminate\Support\Str::uuid(),
            ]
        );
        }
    }
}
