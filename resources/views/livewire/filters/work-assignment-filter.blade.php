<div class="row">
            <div class="col">
                        <div class="form-group mb-2">
                            <label for="type" class="mr-2 filter-dropdown">Coffee Type :</label>
                            <select wire:model.live.debounce.500ms="type" id="type"
                                class="form-control">
                                <option value="">All</option>
                                <option value="robusta">Robusta</option>
                                <option value="arabica">Arabica</option>
                            </select>
                        </div>
            </div>
            <div class="col">
                <div class="form-group mr-2">
                    <label for="min_qtn" class="">Min Quantity: </label>
                    <input id="min_qtn" type="number" class="form-control form-control-sm" wire:model.live.debounce.500ms="minQuantity">
                </div>
            </div>
        <div class="col">
          <div class="form-group mr-2">
            <label for="start_date" class="">Start Date: </label>
            <input id="start_date" type="date" class="form-control form-control-sm" wire:model.live.debounce.500ms="startDate">
        </div>
    </div>
</div>