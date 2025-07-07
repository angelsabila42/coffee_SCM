<div class="overlay" x-show="showModal" x-cloak x-transition>
    <div class = "custom-modal">
        <div class="container">
            <div class="d-flex justify-content-between">
                <h3 class="mt-3">Confirm Dispatch</h3>
                <span @@click="showModal = false"><i class="fa-solid fa-xmark cur"></i></span>
            </div>
                                   
            <h5 class="mt-3 mb-0">Linked Order: {{$order->orderID}} </h5>
            <livewire:vendor-order-dispatch-modal :orderID="$order->id"/>
        </div>
    </div>
</div>