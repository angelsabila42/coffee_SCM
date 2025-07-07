<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Models\RecentActivityLog;

class ActivityLogger{
    public static function log( ?string $title = null, ?string $type = null, array $extras=[]){

        RecentActivityLog::create([
            'user_id'=> $extras['user_id'] ?? (Auth::check() ? Auth::id() : null),
            'title' => $title,
            'type' => $type,
            'ip_address' => Request::ip(),
            'data' => $extras['data'] ?? null
        ]);
    }
}