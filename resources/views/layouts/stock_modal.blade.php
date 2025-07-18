<!-- New Stock Modal -->
<div class="modal fade" id="addInventoryModal" tabindex="-1" aria-labelledby="addInventoryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="{{ route('inventory.add') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">New Stock</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body row g-3">
          <div class="col-md-6">
            <label for="coffee_type" class="form-label">Coffee Type</label>
            <select name="coffee_type" id="coffee_type" class="form-select" required>
              <option value="">Select</option>
              <option value="Arabica">Arabica</option>
              <option value="Robusta">Robusta</option>
              {{-- @foreach($coffeeTypes as $type)
                <option value="{{ $type }}">{{ $type }}</option>
              @endforeach --}}
            </select>
          </div>

          <div class="col-md-6">
            <label for="quantity" class="form-label">Quantity (kg)</label>
            <input type="number" name="quantity" class="form-control" required>
          </div>

          <div class="col-md-6">
            <label for="grade" class="form-label">Grade</label>
            <select name="grade" class="form-select" required>
              <option value="">Select</option>
              <option value="1">A</option>
              <option value="2">B</option>
              <option value="3">C</option>
            </select>
          </div>

          <div class="col-md-6">
            <label for="threshold" class="form-label">Min Threshold</label>
            <input type="number" name="threshold" class="form-control" required>
          </div>

          {{-- <div class="col-md-6">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select" required>
              <option value="">Select</option>
              <option value="in stock">in stock</option>
              <option value="low">Low</option>
            </select>
          </div> --}}

          <div class="col-md-6">
            <label for="warehouse_name" class="form-label">Warehouse</label>
            <select name="warehouse_name" class="form-select" required>
              <option value="">Select</option>
              <option value="Kampala">Kampala</option>
              <option value="Kampala">Mukono</option>
              <option value="Kampala">Mbale</option>
              <option value="Kampala">Mbarara</option>
              {{-- @foreach($warehouses as $w)
                <option value="{{ $w }}">{{ $w }}</option>
              @endforeach --}}
            </select>
          </div>

          <div class="col-md-6">
            <label for="date_added" class="form-label">Date Added</label>
            <input type="date" name="last_updated" class="form-control" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Add</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>
