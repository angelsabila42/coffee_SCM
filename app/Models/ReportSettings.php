<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportSettings extends Model
{
    protected $fillable =['autoGenerateFrequency','preferredTime'];

    /*public function staff(){
        return $this->belongsTo(Staff::class);
    }

    public function transporter(){
        return $this->belongsTo(transporter::class);
    }

    public function vendor(){
        return $this->belongsTo(vendor::class);
    }

    public function importer(){
        return $this->belongsTo(importerModel::class);
    }*/

    /** @use HasFactory<\Database\Factories\ReportSettingsFactory> */
    use HasFactory;
}
