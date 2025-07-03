<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper;


class IncomingOrder extends Model
{
    protected $fillable = ['orderID','quantity','coffeeType','status','deadline','grade','destination', 'importer_model_id', 'declineReason'];

    /*public function vendor(){
        return $this->belongsTo(vendor::class);
    }*/

        public static function booted(){
        static::creating(function($order){
            $order-> orderID = Helper::generateID(IncomingOrder::class,'orderID','KX',5);
        });
    }

        public function getStatusBadgeAttribute()
    {
        return match (ucfirst(strtolower($this->status))){
            'Requested' => 'badge-primary',
            'Pending' => 'badge-warning',
            'Declined' => 'badge-danger',
            'Delivered' => 'badge-secondary',
            'Confirmed' => 'badge-success',
            default=> 'badge-light'
           };
    }

    public function importerModel(){
        return $this->belongsTo(importerModel::class);
    }

      public function notification(){
        return $this->belongsTo(Notification::class);
    }
    /** @use HasFactory<\Database\Factories\IncomingOrderFactory> */
    use HasFactory;
}
