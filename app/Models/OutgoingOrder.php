<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper;

class OutgoingOrder extends Model
{
    protected $fillable = ['orderID','quantity', 'coffeeType','status','deadline', 'vendor_id', 'work_center_id', 'declineReason'];

    public static function booted(){
        static::creating(function($order){
            $order-> orderID = Helper::generateID(OutgoingOrder::class,'orderID','OX',5);
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

    public function vendor(){
        return $this->belongsTo(Vendor::class,'vendor_id');
    }

    public function workCenter(){
        return $this->belongsTo(WorkCenter::class);
    }

      public function notification(){
        return $this->belongsTo(Notification::class);
    }

    public function vendorDispatch(){
        return $this->hasMany(WorkCenter::class);
    }

    /** @use HasFactory<\Database\Factories\OutgoingOrderFactory> */
    use HasFactory;
}
