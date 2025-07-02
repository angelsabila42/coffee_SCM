<div>
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
                    
        <div class="row"> 
        <div class="col">
        <div class="form-group mb-2">
            <label for="status" class="mr-2 filter-dropdown">Status :</label>
                <select wire:model.live.debounce.500ms ="status" id="status"
                class="form-control">
                    <option value="">All</option>
                    <option value="requested">Requested</option>
                    <option value="pending">Pending</option>
                    <option value="cancelled">Cancelled</option> 
                    <option value="delivered">Delivered</option> 
                    <option value="confirmed">Confirmed</option>
                </select>
        </div>
       </div>
      
       
        <div class="col">
        <div class="form mr-3">
            <label class="">Max Quantity: </label>
            <input type="number" class="form-control form-control-sm" wire:model.live.debounce.500ms ="maxQuantity"> 
        </div>
        </div>
      <div class="col">
        <div class="form-group mr-2">
            <label for="end_date" class="">End Date: </label>
            <input id="end_date" type="date" class="form-control form-control-sm" wire:model.live.debounce.500ms ="endDate">
        </div>
      </div> 
        </div>
</div>