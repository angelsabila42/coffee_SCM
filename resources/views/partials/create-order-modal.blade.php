 <!--Order modal-->
                            <div class="overlay" x-show="showModal">
                                <div class = "custom-modal">
                                <div class="container">
                                <div class="d-flex justify-content-between">
                                <h3 class="mt-3 text-brown font-weight-bold">Create New Order</h3>
                                <span @@click="showModal = false"><i class="fa-solid fa-xmark cur"></i></span>
                                </div>
                                   
                                   <h5 class="mt-3 font-weight-bold pl-0">OrderID: {{$orderID}} </h5>
                                        <livewire:create-order-modal/>
                                </div>
                                </div>
                            </div>
                 

