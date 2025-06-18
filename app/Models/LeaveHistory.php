<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Staff;

class LeaveHistory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'staff_id',
        'work_center',
        'leave_type',
        'start_date',
        'end_date',
        
    ];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'leave_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    protected $keyType = 'string';
     // relationship with Staff model
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
