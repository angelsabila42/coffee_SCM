<div class="form-group">
    <label for="delivery_id">Delivery ID:</label>
    <input type="text" class="form-control" id="delivery_id" name="delivery_id" value="{{ $delivery->delivery_id ?? $newDeliveryId ?? '' }}" {{ isset($delivery) ? 'readonly' : '' }} required>
</div>

<!-- Order Selection -->
<div class="form-group">
    <label for="order_reference">Select Order (Optional):</label>
    <select class="form-control" id="order_reference" name="order_reference" onchange="populateFromOrder()">
        <option value="">-- Create manual delivery or select an order --</option>
        @if(isset($availableOrders))
            @foreach($availableOrders as $order)
                <option value="{{ $order->id }}" 
                        data-quantity="{{ $order->quantity }}"
                        data-coffee-type="{{ $order->coffeeType }}"
                        data-grade="{{ $order->grade }}"
                        data-destination="{{ $order->destination }}"
                        {{ old('order_reference', $delivery->order_reference ?? '') == $order->id ? 'selected' : '' }}>
                    {{ $order->orderID }} - {{ $order->coffeeType }} ({{ $order->quantity }}kg) - {{ $order->destination }}
                </option>
            @endforeach
        @endif
    </select>
    <small class="form-text text-muted">Select an existing order to auto-populate delivery details, or leave blank to create a manual delivery request.</small>
</div>

<div class="form-group">
    <label for="pickup_location">Pickup Location:</label>
    <input type="text" class="form-control" id="pickup_location" name="pickup_location" value="{{ old('pickup_location', $delivery->pickup_location ?? '') }}">
</div>

<div class="form-group">
    <label for="dispatch_date_time">Dispatch Date and Time:</label>
    <input type="datetime-local" class="form-control" id="dispatch_date_time" name="dispatch_date_time" value="{{ old('dispatch_date_time', isset($delivery) ? \Carbon\Carbon::parse($delivery->dispatch_date_time)->format('Y-m-d\TH:i') : '') }}">
</div>

<div class="form-group">
    <label for="delivery_destination">Delivery Destination:</label>
    <input type="text" class="form-control" id="delivery_destination" name="delivery_destination" value="{{ old('delivery_destination', $delivery->delivery_destination ?? '') }}" required>
</div>

<div class="form-group">
    <label for="quantity">Quantity (kg):</label>
    <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', $delivery->quantity ?? '') }}" required min="1">
</div>

<div class="form-group">
    <label for="coffee_type">Coffee Type:</label>
    <select class="form-control" id="coffee_type" name="coffee_type" required>
        <option value="">-- Select Coffee Type --</option>
        <option value="arabica" {{ old('coffee_type', $delivery->coffee_type ?? '') == 'arabica' ? 'selected' : '' }}>Arabica</option>
        <option value="robusta" {{ old('coffee_type', $delivery->coffee_type ?? '') == 'robusta' ? 'selected' : '' }}>Robusta</option>
        <option value="blend" {{ old('coffee_type', $delivery->coffee_type ?? '') == 'blend' ? 'selected' : '' }}>Blend</option>
    </select>
</div>

<div class="form-group">
    <label for="coffee_grade">Coffee Grade:</label>
    <input type="text" class="form-control" id="coffee_grade" name="coffee_grade" value="{{ old('coffee_grade', $delivery->coffee_grade ?? '') }}">
</div>

<div class="form-group">
    <label for="status">Status:</label>
    <select class="form-control" id="status" name="status" required>
        <option value="Scheduled" {{ (old('status', $delivery->status ?? '') == 'Scheduled') ? 'selected' : '' }}>Scheduled</option>
        <option value="In transit" {{ (old('status', $delivery->status ?? '') == 'In transit') ? 'selected' : '' }}>In transit</option>
        <option value="Delivered" {{ (old('status', $delivery->status ?? '') == 'Delivered') ? 'selected' : '' }}>Delivered</option>
    </select>
</div>

<div class="form-group">
    <label for="assigned_driver">Assigned Driver:</label>
    <input type="text" class="form-control" id="assigned_driver" name="assigned_driver" value="{{ old('assigned_driver', $delivery->assigned_driver ?? '') }}">
</div>

<div class="form-group">
    <label for="eta">ETA (Estimated Time of Arrival):</label>
    <input type="date" class="form-control" id="eta" name="eta" value="{{ old('eta', isset($delivery->eta) ? \Carbon\Carbon::parse($delivery->eta)->format('Y-m-d') : '') }}">
</div>

<div class="form-group">
    <label for="date_ordered">Date Ordered:</label>
    <input type="date" class="form-control" id="date_ordered" name="date_ordered" value="{{ old('date_ordered', isset($delivery->date_ordered) ? \Carbon\Carbon::parse($delivery->date_ordered)->format('Y-m-d') : '') }}" required>
</div>

<script>
function populateFromOrder() {
    const orderSelect = document.getElementById('order_reference');
    const selectedOption = orderSelect.options[orderSelect.selectedIndex];
    
    if (selectedOption.value && selectedOption.hasAttribute('data-quantity')) {
        // Auto-populate fields from selected order
        document.getElementById('quantity').value = selectedOption.getAttribute('data-quantity');
        document.getElementById('coffee_type').value = selectedOption.getAttribute('data-coffee-type').toLowerCase();
        document.getElementById('coffee_grade').value = selectedOption.getAttribute('data-grade') || '';
        document.getElementById('delivery_destination').value = selectedOption.getAttribute('data-destination') || '';
        
        // Set today's date for date_ordered if not already set
        if (!document.getElementById('date_ordered').value) {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('date_ordered').value = today;
        }
        
        // Show success message
        showMessage('Order details populated successfully!', 'success');
    } else {
        // Clear fields if no order selected
        document.getElementById('quantity').value = '';
        document.getElementById('coffee_type').value = '';
        document.getElementById('coffee_grade').value = '';
        document.getElementById('delivery_destination').value = '';
    }
}

function showMessage(message, type) {
    // Create a temporary alert
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    // Insert at the top of the form
    const form = document.querySelector('form');
    form.insertBefore(alertDiv, form.firstChild);
    
    // Auto-remove after 3 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.parentNode.removeChild(alertDiv);
        }
    }, 3000);
}
</script> 