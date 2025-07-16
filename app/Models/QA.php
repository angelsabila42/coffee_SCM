<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QA extends Model
{
    protected $fillable = [
        'reportID',
        'date',
        'testers_initials',
        'region',
        'vendor_id',
        'ref',
        'crop_year',
        'screen_description',
        'color',
        'defects',
        'fragrance',
        'moisture_content',
        'overall_impression',
        'status'
    ];

    protected $casts = [
        'defects' => 'array',
        'date' => 'date',
        'moisture_content' => 'decimal:2',
        'vendor_id' => 'integer',
        'status' => 'integer'
    ];

    /** @use HasFactory<\Database\Factories\QAFactory> */
    use HasFactory;

    public function vendor()
    {
        return $this->belongsTo(vendor::class);
    }
}
