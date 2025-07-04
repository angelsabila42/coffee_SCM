
    <div  x-show="showFilter" class="mt-3 p-3" x-cloak x-transition>
    @include('livewire.filters.order-filters')
        <div class="row align-items-center">
    <div class="col-md-4">
        <div class="form-group mb-2">
            <label for="country" class="mr-2 filter-dropdown">Country :</label>
                <select wire:model.live.debounce.500ms ="country" 
                class="form-control">
                    <option value="">All</option>
                    @foreach($this->countries as $country)
                    <option value="{{$country->destination}}"> {{$country->destination}} </option>   
                    @endforeach
                </select>
        </div>
       </div>
       <div class="col-auto mt-4"><button class="btn btn-secondary btn-sm cur" wire:click= "clearFilter" >Clear Filters</button></div>


        {{-- <div class="mt-3">
    <strong>Debug:</strong><br>
    Status: {{ $status }} <br>
    Type: {{ $type }} <br>
    Min: {{ $minQuantity }} <br>
    Max: {{ $maxQuantity }} <br>
    Start: {{ $startDate }} <br>
    End: {{ $endDate }}
</div> --}}
        </div>
    </div>

