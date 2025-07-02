
    <div  x-show="showFilter" class="mt-3 p-3" x-cloak x-transition>
    @include('livewire.filters.order-filters')
        
        <div class="row align-items-center">
      <div class="col-md-4">
        <div class="form-group mb-2">
            <label for="country" class="mr-2 filter-dropdown">Grade :</label>
                <select wire:model.live.debounce.500ms ="grade" 
                class="form-control">
                    <option value="">All</option>
                    @foreach($this->grades as $grade)
                    <option value="{{$grade->grade}}"> {{$grade->grade}} </option>   
                    @endforeach
                </select>
        </div>
       </div>
       <div class="col-auto mt-4"><button class="btn btn-secondary btn-sm cur" wire:click= "clearFilter" >Clear Filters</button></div>
        </div>
    </div>

