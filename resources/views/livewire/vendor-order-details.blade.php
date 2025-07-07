{{-- <div>
    {{-- The whole world belongs to you. 
</div> --}}


<div class="d-flex justify-content-between align-items-center">
            <div class="d-flex">
                <button type= "button" class="btn save mr-2" wire:click="acceptOrder">Accept</button>
                <button type= "button" class="btn exit" @@click="showForm= !showForm" wire:click="declineOrder" >Decline</button>
        </div>
            <div class="d-flex">
                <div>
                    <button type= "button" class="btn save mr-2" @@click ="showModal = true" wire:click="confirmDispatch">Confirm Dispatch</button>
                    @include('partials.vendor-order-dispatch')
                </div>   
                <button type= "button" class="btn btn-light btn-fill mr-2" onclick="window.location= '{{route('vendor.order.download', $order->id)}}' " >Download</button>
            </div>
        </div>