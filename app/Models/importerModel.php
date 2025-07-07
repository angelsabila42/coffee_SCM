<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class importerModel extends Model
{
  use Notifiable;
  use HasFactory;
      protected $fillable = [
        'name',
        'email',
        'password',
         'country',
        'phone_number',
        'address',
        'confirm password',
     ];

     public function incoming_order(){
        return $this->hasMany(IncomingOrder::class);
    }

    /**
     * Get the invoices for the importer.
     */
    public function invoices(){
        return $this->hasMany(Invoice::class);
    }
}
