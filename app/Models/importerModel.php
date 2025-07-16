<?php

namespace App\Models;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class ImporterModel extends Model
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
        'Bank_account',
        'Account_holder',
        'Bank_name',
     ];

     public function incoming_order(){
        return $this->hasMany(IncomingOrder::class);
    }
    
     public function payments(){
        return $this->hasMany(Payment::class);
     }
    /**
     * Get the invoices for the importer.
     */
    public function invoices(){
        return $this->hasMany(Invoice::class);
    }

    public function demands(){
        return $this->hasMany(ImporterDemand::class, 'importer_model_id');
    }

    public function demandQuantity(){
        return $this->hasMany(QuantitiyDemand::class);
    }

}