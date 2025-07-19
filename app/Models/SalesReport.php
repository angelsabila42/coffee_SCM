<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesReport extends Model
{
    protected$fillable = [
        'reportID',
        'start_period',
        'end_period',
        'title',
        'data',
        'total_sales',
        'total_quantity',];
    
    /** @use HasFactory<\Database\Factories\SalesReportFactory> */
    use HasFactory;
}
