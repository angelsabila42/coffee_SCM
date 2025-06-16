<div class="form-group">
    <label for="receipt_number">Receipt #</label>
    <input type="text" class="form-control" id="receipt_number" name="receipt_number" value="{{ $payment->receipt_number ?? $newReceiptNumber ?? '' }}" {{ isset($payment) ? 'readonly' : '' }} required>
</div>

<div class="form-group">
    <label for="invoice_id">Invoice ID (Optional)</label>
    <select class="form-control" id="invoice_id" name="invoice_id">
        <option value="">-- Select Invoice --</option>
        @foreach($invoices as $invoice)
            <option value="{{ $invoice->id }}" {{ (old('invoice_id', $payment->invoice_id ?? '') == $invoice->id) ? 'selected' : '' }}>
                {{ $invoice->invoice_number }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="payer">Payer:</label>
    <input type="text" class="form-control" id="payer" name="payer" value="{{ old('payer', $payment->payer ?? '') }}" required>
</div>

<div class="form-group">
    <label for="amount_paid">Amount Paid:</label>
    <input type="number" step="0.01" class="form-control" id="amount_paid" name="amount_paid" value="{{ old('amount_paid', $payment->amount_paid ?? '') }}" required min="0">
</div>

<div class="form-group">
    <label for="date_paid">Date Paid:</label>
    <input type="date" class="form-control" id="date_paid" name="date_paid" value="{{ old('date_paid', isset($payment->date_paid) ? \Carbon\Carbon::parse($payment->date_paid)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d')) }}" required>
</div>

<div class="form-group">
    <label for="payment_mode">Payment Mode:</label>
    <input type="text" class="form-control" id="payment_mode" name="payment_mode" value="{{ old('payment_mode', $payment->payment_mode ?? '') }}">
</div>

<div class="form-group">
    <label for="status">Status:</label>
    <select class="form-control" id="status" name="status" required>
        <option value="Sent" {{ (old('status', $payment->status ?? '') == 'Sent') ? 'selected' : '' }}>Sent</option>
        <option value="Awaiting Pay" {{ (old('status', $payment->status ?? '') == 'Awaiting Pay') ? 'selected' : '' }}>Awaiting Pay</option>
        <option value="Paid" {{ (old('status', $payment->status ?? '') == 'Paid') ? 'selected' : '' }}>Paid</option>
    </select>
</div>

<div class="form-group">
    <label for="coffee_type">Coffee Type (Optional):</label>
    <input type="text" class="form-control" id="coffee_type" name="coffee_type" value="{{ old('coffee_type', $payment->coffee_type ?? '') }}">
</div>

<div class="form-group">
    <label for="payment_description">Description (Optional):</label>
    <input type="text" class="form-control" id="payment_description" name="payment_description" value="{{ old('payment_description', $payment->payment_description ?? '') }}">
</div>

<div class="form-group">
    <label for="recipient_name">Recipient Name (Optional):</label>
    <input type="text" class="form-control" id="recipient_name" name="recipient_name" value="{{ old('recipient_name', $payment->recipient_name ?? '') }}">
</div>

<div class="form-group">
    <label for="receipt_file">Upload Receipt (PDF, JPG, PNG)</label>
    <input type="file" class="form-control-file" id="receipt_file" name="receipt_file">
    @if(isset($payment) && $payment->receipt_file_path)
        <small class="form-text text-muted">Current file: <a href="{{ asset('storage/' . $payment->receipt_file_path) }}" target="_blank">View</a></small>
    @endif
</div> 