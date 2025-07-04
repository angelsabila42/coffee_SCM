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
        'work_center',
        'role',
        'status',
        'phone_number',
        'email',
       
        ];
         //  relationships for WorkAssignment and Leave
    public function workAssignments()
    {       // // A Staff member has many WorkAssignments
        return $this->hasMany(WorkAssignment::class);
    }

    public function leaveHistory()
    {
        return $this->hasMany(LeaveHistory::class);
    }
}
