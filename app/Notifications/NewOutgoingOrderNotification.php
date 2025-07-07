<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;


class NewOutgoingOrderNotification extends Notification
{
    use Queueable;

    public $order;
    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'New Outgoing Order: ' . $this->order->orderID,
            'order_id' => $this->order->id,
            // 'type' => 'outgoing_order',
            // 'url' => '/vendor/outgoing-orders',
        ];
    }
}
