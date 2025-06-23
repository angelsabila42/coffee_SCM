<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportSettings extends Model
{
    protected $fillable =['autoGenerateFrequency','preferredTime'];
    /** @use HasFactory<\Database\Factories\ReportSettingsFactory> */
    use HasFactory;
}
