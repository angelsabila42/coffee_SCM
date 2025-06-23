<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomingOrder extends Model
{
    protected $fillable = ['orderID','quantity','coffeeType','status','deadline','grade','destination'];

    /*public function vendor(){
        return $this->belongsTo(vendor::class);
    }*/

      public function notification(){
        return $this->belongsTo(Notification::class);
    }
    /** @use HasFactory<\Database\Factories\IncomingOrderFactory> */
    use HasFactory;
}
