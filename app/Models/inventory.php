<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class inventory extends Model
{
    protected $fillable=[
        'coffee_type',
        'grade',
        'garehouse_name',
        'quantity',
        'threshold',
        'status',
        'last_updated',
        

    ];
}
