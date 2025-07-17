<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatusLogger extends Model
{
    /** @use HasFactory<\Database\Factories\OrderStatusLoggerFactory> */
    use HasFactory;

    protected $fillable =['action', 'user_id', 'loggable_id', 'loggable_type'];

    public function getActionStatusBadgeAttribute()
    {
        preg_match('/from (\w+) to (\w+)/', $this->action, $matches );
        $newStatus = ucfirst(strtolower($matches[2] ?? ''));
        $oldStatus = ucfirst(strtolower($matches[1] ?? ''));
        $badgeMap=[
            'Requested' => 'badge badge-pill badge-primary',
            'Pending' => 'badge badge-pill badge-warning',
            'Declined' => 'badge badge-pill badge-danger',
            'Delivered' => 'badge badge-pill badge-secondary',
            'Confirmed' => 'badge badge-pill badge-success',
           ];

           $oldColored = isset($badgeMap[$oldStatus])
           ? "<span class =\"{$badgeMap[$oldStatus]}\">$oldStatus</span>"
           : "<span class =\"text-light\">$oldStatus</span>";

           $newColored = isset($badgeMap[$newStatus])
           ? "<span class =\"{$badgeMap[$newStatus]}\">$newStatus</span>"
           : "<span class =\"text-light\">$newStatus</span>";

           return  "Status changed from $oldColored to $newColored";
    }


    public function loggable(){
        return $this->morphTo();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
