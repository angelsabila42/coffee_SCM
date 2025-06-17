<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class incoming_order extends Model
{
    protected $fillable=[
        'quantity',
        'order_date',
        'status',

    ];
    
}
