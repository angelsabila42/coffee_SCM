<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutgoingOrder extends Model
{
    protected $fillable = ['orderID','quantity','status','deadline'];
    /** @use HasFactory<\Database\Factories\OutgoingOrderFactory> */
    use HasFactory;
}
