<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorOrderDispatch extends Model
{
    protected $fillable= ['quantity', 'dateDispatched', 'coffeeType', 'work_center_id', 'outgoing_order_id'];
    /** @use HasFactory<\Database\Factories\VendorOrderDispatchFactory> */
    use HasFactory;

    public function outgoingOrder(){
         return $this->belongsTo(OutgoingOrder::class);
    }

    public function workCenter(){
        return $this->belongsTo(WorkCenter::class);
    }

}

