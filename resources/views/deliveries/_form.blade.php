<div class="form-group">
    <label for="delivery_id">Delivery ID:</label>
    <input type="text" class="form-control" id="delivery_id" name="delivery_id" value="{{ $delivery->delivery_id ?? $newDeliveryId ?? '' }}" {{ isset($delivery) ? 'readonly' : '' }} required>
</div>

<div class="form-group">
    <label for="pickup_location">Pickup Location:</label>
    <input type="text" class="form-control" id="pickup_location" name="pickup_location" value="{{ old('pickup_location', $delivery->pickup_location ?? '') }}">
</div>

<div class="form-group">
    <label for="dispatch_date_time">Dispatch Date and Time:</label>
    <input type="datetime-local" class="form-control" id="dispatch_date_time" name="dispatch_date_time" value="{{ old('dispatch_date_time', isset($delivery) ? \Carbon\Carbon::parse($delivery->dispatch_date_time)->format('Y-m-d\TH:i') : '') }}">
    
<form wire:submit.prevent="submit">
    <label for="coffee_type">Select Coffee Type:</label>
    <select wire:model="coffee_type" id="coffee_type" class="form-control">
        <option value="arabica">Arabica</option>
        <option value="robusta">Robusta</option>
    </select>

    <button type="submit" class="btn btn-primary mt-3">Submit</button>
</form>

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