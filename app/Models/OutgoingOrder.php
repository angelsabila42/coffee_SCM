<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper;

class OutgoingOrder extends Model
{
    protected $fillable = ['orderID','quantity', 'coffeeType','status','deadline', 'vendor_id', 'work_center_id'];

    public static function booted(){
        static::creating(function($order){
            $order-> orderID = Helper::generateID(OutgoingOrder::class,'orderID','OX',5);
        });
    }

    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }

    public function workCenter(){
        return $this->belongsTo(WorkCenter::class);
    }

      public function notification(){
        return $this->belongsTo(Notification::class);
    }
    /** @use HasFactory<\Database\Factories\OutgoingOrderFactory> */
    use HasFactory;
}
