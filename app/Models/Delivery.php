<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    /**
     * Get the transporter for this delivery.
     */
    public function transporter()
    {
        return $this->belongsTo(Transporter::class);
    }
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
        'date_ordered',
        'order_reference',
        'confirmed_by_admin',
        'admin_confirmed_at',
        'transporter_id',
    ];

      public function notification(){
        return $this->belongsTo(Notification::class);
    }
    
    /**
     * Get the order associated with this delivery.
     */
    public function order()
    {
        return $this->belongsTo(IncomingOrder::class, 'order_reference');
    }
}
