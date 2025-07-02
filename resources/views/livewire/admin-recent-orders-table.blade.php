<div wire:poll.10s class="modern-card ">
                        <div class="col-md-12">
                            <div class=" table-plain-bg">
                                <h4 class="card-header ">Recent Orders</h4>
                                
                                <div class="card-body table-full-width table-responsive">
                                    <table class="table table-hover">
                                        <thead class="bg-light">
                                            <th>OrderID</th>
                                            <th>Importer Name</th>
                                            <th>Coffee Type</th>
                                            <th>Quantity</th>
                                            <th>Status</th>
                                            <th>Delivery Country</th>
                                            <th>Date Sent</th>
                                            <th  class=" d-flex justify-content-center align-items-center">Actions</th>
                                        </thead>
                                        <tbody>
                                        @foreach($orders as $order)
                                            <tr wire:key= "{{$order->id}}" >
                                                 <td class=""> {{$order->orderID}} </td>
                                                <td class=""> {{$order->importerModel->name}} </td>
                                                <td class=""> {{$order->coffeeType}} </td>
                                                <td class=""> {{$order->quantity}} </td>
                                                <td class=""> {{$order->status}} </td>
                                                <td class=""> {{$order->destination}} </td>
                                                <td class=""> {{$order->created_at}} </td>
                                                <td class=" d-flex justify-content-center align-items-center">
                                                <button wire:click="delete({{$order->id}})" class="btn btn-danger btn-sm btn-fill py-1 px-3"><i class="fa-solid fa-trash"></i></button>
                                                </td>
                                            </tr>
                                         @endforeach    
                                        </tbody>
                                    </table>
                                </div>
                                <div class="py-4 px-3">
                   
                            </div>
                        </div>
                        </div>
</div>
