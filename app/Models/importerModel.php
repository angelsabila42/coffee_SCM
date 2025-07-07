<?php

namespace App\Models;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ImporterModel extends Model
{
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
    
     public function payments(){
        return $this->hasMany(Payment::class);
    }
}
