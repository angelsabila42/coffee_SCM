<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    protected $fillable= ['in-app-alerts','email-alerts'];
    /** @use HasFactory<\Database\Factories\NotificationSettingFactory> */
    use HasFactory;
}
