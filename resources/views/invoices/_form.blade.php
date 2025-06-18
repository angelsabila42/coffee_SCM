<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="invoice_number">Invoice #</label>
            <input type="text" class="form-control" id="invoice_number" name="invoice_number" value="{{ $invoice->invoice_number ?? $newInvoiceNumber ?? '' }}" {{ isset($invoice) ? 'readonly' : '' }} required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="invoice_date">Invoice Date</label>
            <input type="date" class="form-control" id="invoice_date" name="invoice_date" value="{{ old('invoice_date', isset($invoice->invoice_date) ? \Carbon\Carbon::parse($invoice->invoice_date)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d')) }}" required>
        </div>
    </div>
</div>

<h5 class="mt-4">Vendor Information</h5>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="vendor_name">Vendor Name</label>
            <input type="text" class="form-control" id="vendor_name" name="vendor_name" value="{{ old('vendor_name', $invoice->vendor_name ?? '') }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="vendor_po_box">Vendor P.O Box</label>
            <input type="text" class="form-control" id="vendor_po_box" name="vendor_po_box" value="{{ old('vendor_po_box', $invoice->vendor_po_box ?? '') }}">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="vendor_city">Vendor City</label>
            <input type="text" class="form-control" id="vendor_city" name="vendor_city" value="{{ old('vendor_city', $invoice->vendor_city ?? '') }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="vendor_country">Vendor Country</label>
            <input type="text" class="form-control" id="vendor_country" name="vendor_country" value="{{ old('vendor_country', $invoice->vendor_country ?? '') }}">
        </div>
    </div>
</div>

<h5 class="mt-4">Bill To Information</h5>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="bill_to_name">Bill To Name</label>
            <input type="text" class="form-control" id="bill_to_name" name="bill_to_name" value="{{ old('bill_to_name', $invoice->bill_to_name ?? '') }}" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="bill_to_po_box">Bill To P.O Box</label>
            <input type="text" class="form-control" id="bill_to_po_box" name="bill_to_po_box" value="{{ old('bill_to_po_box', $invoice->bill_to_po_box ?? '') }}">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="bill_to_city">Bill To City</label>
            <input type="text" class="form-control" id="bill_to_city" name="bill_to_city" value="{{ old('bill_to_city', $invoice->bill_to_city ?? '') }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="bill_to_country">Bill To Country</label>
            <input type="text" class="form-control" id="bill_to_country" name="bill_to_country" value="{{ old('bill_to_country', $invoice->bill_to_country ?? '') }}">
        </div>
    </div>
</div>

<h5 class="mt-4">Invoice Items</h5>
<div id="invoice-items-container">
    @if (isset($invoice) && $invoice->items->count() > 0)
        @foreach ($invoice->items as $item)
            @include('invoices._item_row', ['item' => $item, 'loopIndex' => $loop->index])
        @endforeach
    @else
        @include('invoices._item_row', ['loopIndex' => 0])
    @endif
</div>
<button type="button" class="btn btn-secondary btn-sm" id="add-item-row">Add Item</button>

<h5 class="mt-4">Totals & Bank Details</h5>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="sub_total">Sub Total</label>
            <input type="number" step="0.01" class="form-control" id="sub_total" name="sub_total" value="{{ old('sub_total', $invoice->sub_total ?? '') }}" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="total">Total</label>
            <input type="number" step="0.01" class="form-control" id="total" name="total" value="{{ old('total', $invoice->total ?? '') }}" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="currency">Currency</label>
            <input type="text" class="form-control" id="currency" name="currency" value="{{ old('currency', $invoice->currency ?? 'Ugx') }}" required>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="bank_account_no">Bank Account No</label>
            <input type="text" class="form-control" id="bank_account_no" name="bank_account_no" value="{{ old('bank_account_no', $invoice->bank_account_no ?? '') }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="bank_name">Bank Name</label>
            <input type="text" class="form-control" id="bank_name" name="bank_name" value="{{ old('bank_name', $invoice->bank_name ?? '') }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="Sent" {{ (old('status', $invoice->status ?? '') == 'Sent') ? 'selected' : '' }}>Sent</option>
                <option value="Awaiting Pay" {{ (old('status', $invoice->status ?? '') == 'Awaiting Pay') ? 'selected' : '' }}>Awaiting Pay</option>
                <option value="Paid" {{ (old('status', $invoice->status ?? '') == 'Paid') ? 'selected' : '' }}>Paid</option>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="purpose">Purpose</label>
            <input type="text" class="form-control" id="purpose" name="purpose" value="{{ old('purpose', $invoice->purpose ?? '') }}">
        </div>
    </div>
</div>

<div class="form-group">
    <label for="recipient_phone">Recipient Phone</label>
    <input type="text" class="form-control" id="recipient_phone" name="recipient_phone" value="{{ old('recipient_phone', $invoice->recipient_phone ?? '') }}">
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let itemIndex = {{ (isset($invoice) && $invoice->items->count() > 0) ? $invoice->items->count() : 1 }};

        document.getElementById('add-item-row').addEventListener('click', function () {
            const container = document.getElementById('invoice-items-container');
            const newRow = document.createElement('div');
            newRow.classList.add('row', 'mb-2', 'invoice-item-row');
            newRow.innerHTML = `
                <input type="hidden" name="items[${itemIndex}][id]" value="">
                <div class="col-md-5">
                    <input type="text" name="items[${itemIndex}][description]" class="form-control" placeholder="Description" required>
                </div>
                <div class="col-md-2">
                    <input type="number" name="items[${itemIndex}][quantity]" class="form-control" placeholder="Quantity" required min="1">
                </div>
                <div class="col-md-3">
                    <input type="number" step="0.01" name="items[${itemIndex}][unit_price]" class="form-control" placeholder="Unit Price" required min="0">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm remove-item-row">Remove</button>
                </div>
            `;
            container.appendChild(newRow);
            itemIndex++;
            attachRemoveListeners();
        });

        function attachRemoveListeners() {
            document.querySelectorAll('.remove-item-row').forEach(button => {
                button.onclick = function() {
                    this.closest('.invoice-item-row').remove();
                };
            });
        }

        attachRemoveListeners(); // Attach listeners for existing items on page load
    });
</script> 