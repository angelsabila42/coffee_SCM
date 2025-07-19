<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesaPalTransaction extends Model
{
    use HasFactory;

    protected $table = 'pesapal_transactions';

    protected $fillable = [
        'pesapal_tracking_id',
        'pesapal_merchant_reference',
        'importer_id',
        'order_ids',
        'total_amount',
        'status',
        'payment_method',
        'payment_date',
        'pesapal_response',
        'description',
        'payment_type',
        'vendor_id',
        'transporter_id',
        'delivery_route',
    ];

    protected $casts = [
        'order_ids' => 'array',
        'pesapal_response' => 'array',
        'payment_date' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    public function importer()
    {
        return $this->belongsTo(ImporterModel::class);
    }

    public function orders()
    {
        return $this->hasMany(IncomingOrder::class, 'id', 'order_ids');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'PENDING');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'COMPLETED');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'FAILED');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function transporter()
    {
        return $this->belongsTo(Transporter::class);
    }
}
