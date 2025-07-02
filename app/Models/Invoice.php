<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'vendor_name',
        'vendor_po_box',
        'vendor_city',
        'vendor_country',
        'bill_to_name',
        'bill_to_po_box',
        'bill_to_city',
        'bill_to_country',
        'sub_total',
        'total',
        'currency',
        'bank_account_no',
        'bank_name',
        'status',
        'purpose',
        'recipient_phone',
    ];

    /**
     * Get the invoice items for the invoice.
     */
    public function notification(){
        return $this->belongsTo(Notification::class);
    }

    public function importer(){
        return $this->hasMany(importerModel::class);
    }

    public function vendor(){
        return $this->hasMany(Vendor::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
