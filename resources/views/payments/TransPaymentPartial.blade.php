<div class="modern-card m-3 p-3 rounded-pill w-50">
    <div>
    <h2>Payment Details</h2>
    <p><strong>Invoice ID:</strong> {{ $payment->invoice_id }}</p>
    <p><strong>Payer:</strong> {{ $payment->payer }}</p>
    <p><strong>Amount Paid:</strong> {{ $payment->amount_paid }}</p>
    <p><strong>Date Paid:</strong> {{ $payment->date_paid }}</p>
    <p><strong>Payment Mode:</strong> {{ $payment->payment_mode }}</p>
    <p><strong>Status:</strong> {{ $payment->status }}</p>
    <p><strong>Coffee Type:</strong> {{ $payment->coffee_type }}</p>
    <p><strong>Recipient:</strong> {{ $payment->recipient_name }}</p>
     <p><strong>Payment description:</strong> {{ $payment->payment_description }}</p>

    </div>
   
</div>

