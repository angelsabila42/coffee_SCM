<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Model
{
     use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'staff';

    /**
     * The attributes are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name',
        'role',
        'status',
        'phone_number',
        'email',
        'profile_picture'
    ];

    /**
     * Get the profile picture URL.
     *
     * @return string
     */
    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture) {
            return asset('storage/' . $this->profile_picture);
        }
        return asset('assets/img/default-avatar.png');
    }

    // relationships for WorkAssignment and Leave
    public function workAssignments()
    {
        return $this->hasMany(WorkAssignment::class);
    }

    public function leaveHistory()
    {
        return $this->hasMany(LeaveHistory::class);
    }

   
}
