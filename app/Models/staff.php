<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Model
{
     use HasFactory;

    /**
     * The attributes are mass assignable.
     */
    protected $fillable = [
        'full_name',
        'role',
        'status',
        'phone_number',
        'email',
    ];
    // relationships for WorkAssignment and Leave
    public function workAssignments()
    {
        return $this->hasMany(WorkAssignment::class);
    }

    public function leaveHistory()
    {
        return $this->hasMany(LeaveHistory::class);
    }

    // Optional: relationship to work center if needed
    // public function workCenter()
    // {
    //     return $this->belongsTo(WorkCenter::class, 'work_center_id');
    // }
}
