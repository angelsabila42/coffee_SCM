<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['NotID','message','is_read'];
    /** @use HasFactory<\Database\Factories\NotificationFactory> */
    use HasFactory;
}
