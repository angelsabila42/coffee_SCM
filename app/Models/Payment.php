<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'receipt_number',
        'invoice_id',
        'payer',
        'amount_paid',
        'date_paid',
        'payment_mode',
        'status',
        'coffee_type',
        'payment_description',
        'recipient_name',
        'receipt_file_path',
    ];

    /**
     * Get the invoice that the payment belongs to.
     */

    public function notification(){
        return $this->belongsTo(Notification::class);
    } 
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }


     public function importers(){
        return $this->belongsTo(importerModel::class);
    }

}
