<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['NotID','message','is_read', 'type' ];

    //   public function incomingOrder(){
    //     return $this->belongsTo(IncomingOrder::class);
    // }

    //   public function outgoingOrder(){
    //     return $this->belongsTo(OutgoingOrder::class);
    // }

    //   public function invoice(){
    //     return $this->belongsTo(Invoice::class);
    // }

    //   public function payment(){
    //     return $this->belongsTo(Payment::class);
    // }

    //   public function delivery(){
    //     return $this->belongsTo(Delivery::class);
    // }
    /** @use HasFactory<\Database\Factories\NotificationFactory> */
    use HasFactory;
}
