<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkCenter extends Model
{
    use HasFactory;

    // Only use default 'id' for relationships
    protected $fillable = ['centerName', 'location'];

    public function outgoingOrder()
    {
        return $this->hasMany(OutgoingOrder::class);
    }

    public function vendorDispatch(){
        return $this->belongsTo(WorkCenter::class);
    }

    public function workAssignments()
    {
        return $this->hasMany(WorkAssignment::class, 'work_center_id');
    }
    /** @use HasFactory<\Database\Factories\WorkCenterFactory> */
    use HasFactory;
}
