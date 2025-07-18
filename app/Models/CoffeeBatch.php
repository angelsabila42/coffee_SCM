<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoffeeBatch extends Model
{
    protected $table = 'coffee_batches';
    
    protected $fillable = [
        'coffee_type',
        'grade',
        'price_per_kilogram',
        
    ];

    /** @use HasFactory<\Database\Factories\CoffeeBatchFactory> */
}
