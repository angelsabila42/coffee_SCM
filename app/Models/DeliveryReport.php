<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryReport extends Model
{
     protected$fillable = [
        'reportID', 
        'start_period',
        'end_period',
        'title',
        'data',
        'total_deliveries',];
    /** @use HasFactory<\Database\Factories\DeliveryReportFactory> */
    use HasFactory;
}
