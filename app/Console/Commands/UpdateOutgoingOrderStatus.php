<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\OutgoingOrder;
use Illuminate\Support\Facades\Log;

class UpdateOutgoingOrderStatus extends Command
{
    protected $signature = 'orders:update-outgoing';
    protected $description = 'Updates statuses for outgoing orders based on business rules';

    public function handle()
    {
        Log::info('Outgoing order status update started at ' . now());

        // Requested orders older than 2 days -> pending
        $requestedOrders = OutgoingOrder::where('status', 'requested')
            ->where('created_at', '<', now()->subDays(2))
            ->get();

        foreach ($requestedOrders as $order) {
            $order->status = 'pending';
            $order->save();
        }

        Log::info('Outgoing requested -> pending updated. Count: ' . $requestedOrders->count());

        // Pending orders older than 7 days -> declined
        $pendingOrders = OutgoingOrder::where('status', 'pending')
            ->where('created_at', '<', now()->subDays(7))
            ->get();

        foreach ($pendingOrders as $order) {
            $order->status = 'declined';
            $order->save();
        }

        Log::info('Outgoing pending -> declined updated. Count: ' . $pendingOrders->count());

        $this->info('Outgoing order statuses updated successfully.');
    }
}