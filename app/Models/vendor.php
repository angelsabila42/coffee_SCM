<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Vendor extends Model
{
     use Notifiable;
    use HasFactory;
    protected $table = 'vendor';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'street',
        'city',
        'confirm password',
        'Bank_account',
        'Account_holder',
        'Bank_name',
    ];

    public function outgoingOrder(){
         return $this->hasMany(OutgoingOrder::class);
    }

    /**
     * Get the invoices for the vendor.
     */
    public function invoices(){
        return $this->hasMany(Invoice::class);
    }

    public function qaReports()
    {
        return $this->hasMany(QA::class);
    }
}
