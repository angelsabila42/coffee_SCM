<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkCenter extends Model
{
    protected $fillable =['workCenterID','centerName','location'];

      public static function booted(){
        static::creating(function($work){
            $work-> workCenterID = Helper::generateID(WorkCenter::class,'workCenterID','WK',5);
        });
    }


    public function outgoingOrder(){
        return $this->hasMany(OutgoingOrder::class);
    }

    public function vendorDispatch(){
        return $this->belongsTo(WorkCenter::class);
    }
    /** @use HasFactory<\Database\Factories\WorkCenterFactory> */
    use HasFactory;
}
