<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\IncomingOrder;
use Illuminate\Support\Facades\Log;

class UpdateIncomingOrderStatus extends Command
{
    protected $signature = 'orders:update-incoming';
    protected $description = 'Updates statuses for incoming orders based on business rules';

    public function handle()
    {
        Log::info('Incoming order status update started at ' . now());

        // Requested orders older than 2 days -> pending
        $requestedOrders = IncomingOrder::where('status', 'requested')
            ->where('created_at', '<', now()->subDays(2))
            ->get();

        foreach ($requestedOrders as $order) {
            $order->status = 'pending';
            $order->save();
        }

        Log::info('Incoming requested -> pending updated. Count: ' . $requestedOrders->count());

        // Pending orders older than 7 days -> declined
        $pendingOrders = IncomingOrder::where('status', 'pending')
            ->where('created_at', '<', now()->subDays(7))
            ->get();

        foreach ($pendingOrders as $order) {
            $order->status = 'declined';
            $order->save();
        }

        Log::info('Incoming pending -> declined updated. Count: ' . $pendingOrders->count());

        $this->info('Incoming order statuses updated successfully.');
    }
}
