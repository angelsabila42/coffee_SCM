<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomingOrder extends Model
{
    protected $fillable = ['orderID','quantity','status','deadline','grade','destination'];
    /** @use HasFactory<\Database\Factories\IncomingOrderFactory> */
    use HasFactory;
}
