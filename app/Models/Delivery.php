<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'delivery_id',
        'pickup_location',
        'dispatch_date_time',
        'delivery_destination',
        'quantity',
        'coffee_type',
        'coffee_grade',
        'status',
        'assigned_driver',
        'eta',
        'date_ordered',
    ];
}
