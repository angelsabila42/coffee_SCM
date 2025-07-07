<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transporter extends Model
{
     protected $fillable = [
        'name',
        'co_name',
        'email',
        'password',
        'phone_number',
        'address',
        'confirm password',
     ];

    /**
     * Get the invoices for the transporter.
     */
    public function invoices(){
        return $this->hasMany(Invoice::class);
    }
}
