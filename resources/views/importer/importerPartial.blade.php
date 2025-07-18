<div class="modern-card m-3 p-3 rounded-pill w-50">
    <div>
    <h2>Payment Details</h2>
    <p><strong>Order ID:</strong> {{ $order->orderID }}</p>
    <p><strong>Created at:</strong> {{ $order->created_at }}</p>
    <p><strong>Quantity:</strong> {{ $order->quantity }}</p>
    <p><strong>Coffee type:</strong> {{ $order->coffeeType }}</p>
    <p><strong>Status:</strong> {{ $order->status }}</p>
    <p><strong>Deadline:</strong> {{ $order->deadline }}</p>
    <p><strong>Grade:</strong> {{ $order->grade }}</p>
    <p><strong>Destination:</strong> {{ $order->destination }}</p>
         <button class="btn btn-primary m-3" onclick="window.history.back()">Back</button>

    </div>
   
</div>

