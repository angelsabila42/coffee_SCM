<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper;

class WorkCenter extends Model
{
    use HasFactory;

    // Only use default 'id' for relationships
    protected $fillable = ['centerName', 'location', 'workCenterID'];

    public static function booted(){
        static::creating(function($workCenterID){
            $workCenterID-> workCenterID = Helper::generateID(WorkCenter::class,'workCenterID','WK',5);
        });
    }

    public function outgoingOrder()
    {
        return $this->hasMany(OutgoingOrder::class);
    }

    public function vendorDispatch(){
        return $this->belongsTo(WorkCenter::class);
    }
    /** @use HasFactory<\Database\Factories\WorkCenterFactory> */
    use HasFactory;
}
