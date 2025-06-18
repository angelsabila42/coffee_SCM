<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesReport extends Model
{
    protected$fillable = ['start_date', 'end_start'];
    
    /** @use HasFactory<\Database\Factories\SalesReportFactory> */
    use HasFactory;
}
