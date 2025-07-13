<?php

namespace App\Listeners;

use App\Events\OrderDispatched;
use App\Models\Delivery;
use App\Helpers\Helper;
use Illuminate\Support\Str;

class CreateDeliveryRequest
{
    public function handle(OrderDispatched $event)
    {
        $order = $event->order;
        
        // Generate a unique delivery ID
        $deliveryId = 'NX_' . str_pad(Delivery::max('id') + 1, 3, '0', STR_PAD_LEFT);
        
        // Create delivery request from the dispatched order
        Delivery::create([
            'delivery_id' => $deliveryId,
            'coffee_type' => $order->coffeeType,
            'quantity' => $order->quantity,
            'delivery_destination' => $order->destination ?? 'Export Terminal',
            'coffee_grade' => $order->grade ?? 'A',
            'status' => 'Requested', // Pending admin confirmation
            'date_ordered' => now(),
            'order_reference' => $order->orderID, // Link to original order
        ]);
    }
}
