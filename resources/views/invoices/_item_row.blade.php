<div class="row mb-2 invoice-item-row">
    <input type="hidden" name="items[{{ $loopIndex ?? 0 }}][id]" value="{{ $item->id ?? '' }}">
    <div class="col-md-5">
        <input type="text" name="items[{{ $loopIndex ?? 0 }}][description]" class="form-control" placeholder="Description" value="{{ old('items.' . ($loopIndex ?? 0) . '.description', $item->description ?? '') }}" required>
    </div>
    <div class="col-md-2">
        <input type="number" name="items[{{ $loopIndex ?? 0 }}][quantity]" class="form-control" placeholder="Quantity" value="{{ old('items.' . ($loopIndex ?? 0) . '.quantity', $item->quantity ?? '') }}" required min="1">
    </div>
    <div class="col-md-3">
        <input type="number" step="0.01" name="items[{{ $loopIndex ?? 0 }}][unit_price]" class="form-control" placeholder="Unit Price" value="{{ old('items.' . ($loopIndex ?? 0) . '.unit_price', $item->unit_price ?? '') }}" required min="0">
    </div>
    <div class="col-md-2">
        <button type="button" class="btn btn-danger btn-sm remove-item-row">Remove</button>
    </div>
</div> 