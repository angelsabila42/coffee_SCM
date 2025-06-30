{{-- summary cards --}}
     <div class="row mb-4">
        <div class="col">
            <div class="card text-white rounded-2 bg-dark">
                <div class="card-body bg-dark rounded-3">
                   {{-- Dynamically get total staff count --}}
                    <p class="card-title text-white">Orders sent</p>
                    <h3>3</h3> 
                </div>
            </div>
        </div>
        <div class="col ">
            <div class="card ">
                <div class="card-body rounded d-flex ">
                    {{-- Dynamically get absent staff count --}}
                    
                    <div class="mx-3">
                        <span >Pending</span>
                    <h3>4</h3>
                    </div>
                    <i class="fa-solid fa-spinner"></i>
                </div>
            </div>
        </div>
        <div class="col" >
            <div class="card ">
                <div class="card-body d-flex justify-content-column ">
                    
                   <div class="mx-2">
                      <p class="fw-bold ">In transit</p>
                        <h3>4</h3>
                          
                   </div>
                   <i class="fa-solid fa-truck"></i>
               
                    </div>
            </div>
        </div>
        <div class="col">
            <div class="card ">
                <div class="card-body d-flex">
                    <div class="mx-2">
                    {{-- Dynamically get present staff count --}}
                    <p>Delivered</p>
                    <h3>4</h3>
                    </div>
                <i class="fa-solid fa-thumbs-up"></i>
                </div>
            </div>
        </div>
    </div>
{{-- delivery table     --}}
<div>
   <div class="col-md-12">
        <div class="d-flex justify justify-content-between align-items-center">
            <!--Search bar-->
            <div class="d-flex justify-content-center align-items-center">
                {{-- <div class="form">
                    <i class="nc-icon nc-zoom-split"></i>
                    <input type="text" class="form-control form-input" placeholder="Search">
                </div> --}}
                <h3>Order activity</h3>
            </div>
        </div>
        <div class="card card-plain table-plain-bg">
            <div class="card-header ">
                <!--h4 class="card-title">Table on Plain Background</h4>
                <p class="card-category">Here is a subtitle for this table</p-->
            </div>
            <div class="card-body table-full-width table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="bg-light bg-dark ">
                        <th class="font-weight-bold text-white">OrderID</th>
                        <th class="text-amber text-white">Coffee Type</th>
                        <th class="text-amber text-white">Quantity</th>
                        <th class="text-amber text-white">Status</th>
                        <th class="text-amber text-white">Order date</th>
                        <th class="text-amber text-white">Last update</th>
                        <th class="text-amber text-white">Actions</th>
                    </thead>
                    <tbody>
                    <tr>
                        <td>NX-009</td>
                        <td>Arabica</td>
                        <td>3000kg</td>
                        <td>In transit</td>
                        <td>2025-09-05</td>
                        <td>Acccepted</td>
                        <td> <button id="" class="btn btn-sm btn-danger" onclick="confirmDelete('NX-009')"> Delete </button></td>
                    </tr>
                    </tbody>
                </table>
  
<script>
  function confirmDelete(orderId) {
    Swal.fire({
      title: 'Confirm Deletion',
      text: "Are you sure you want to delete this order?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'Cancel'
    }).then((result) => {
      if (result.isConfirmed) {
        // Proceed with deletion
        // You can make an AJAX call here to delete the order
        console.log('Order ' + orderId + ' deleted');
        Swal.fire(
          'Deleted!',
          'Your order has been deleted.',
          'success'
        )
      }
    })
  }
</script>

            </div>
        </div>
    </div>
</div>