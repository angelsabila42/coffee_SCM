<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecentActivityLog extends Model
{
    /** @use HasFactory<\Database\Factories\RecentActivityLogFactory> */
    use HasFactory;

    protected $fillable = ['user_id','title', 'type', 'ip_address', 'data'];
    protected $casts= [
        'data' => 'array'
    ];

    public function getStyleAttribute(){
        return config("activity.{$this->type}") ?? config("activity.default");
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
