<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class inventory extends Model
{
    protected $fillable=[
        'coffee_type',
        'grade',
        'warehouse_name',
        'quantity',
        'threshold',
        'status',
        'last_updated',
        

    ];
    use HasFactory;
}
