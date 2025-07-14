
  <style>
    .section-header {
      font-weight: bold;
      font-size: 24px;
      margin-bottom: 20px;
    }
    .detail-label {
      font-weight: 500;
    }
     .edit-btn {
      float: right;
    } 
  </style>
  
<div class="wrapper">
  <div class="main-panel">
    <div class="container bg-white p-4 rounded shadow-sm">
      <div class="row">
        <div class="col-md-6">
          <p><span class="detail-label">Inventory ID:</span> {{$inventory->inventory_id}}</p>
          <p><span class="detail-label">Coffee Type:</span> {{$inventory->coffee_type}}</p>
          <p><span class="detail-label">Grade:</span>{{$inventory->grade}}</p>
          <p><span class="detail-label">Warehouse Name:</span> {{$inventory->warehouse_name}}</p>
        </div>
        <div class="col-md-6">
          <p>
            <span class="detail-label">Quantity in Stock:</span> {{$inventory->quantity}}
            {{-- <button class="btn btn-sm btn-dark edit-btn">Edit</button> --}}
          </p>
          <p>
            <span class="detail-label">Min Threshold:</span> {{$inventory->threshold}}
            {{-- <button class="btn btn-sm btn-dark edit-btn">Edit</button> --}}
          </p>
          <p><span class="detail-label">Last Updated:</span> {{$inventory->last_updated}}</p>
          <p><span class="detail-label">Status:</span> 
            @if($inventory->quantity < $inventory->threshold)
              <span class="text-danger">Low X</span>
            @else 
              <span class="text-success">In Stock ✔️</span>
            @endif
          </p>
        </div>
      </div>
      <hr>
      <h5 class="mt-4">Inventory Log</h5>
      <table class="table table-bordered table-hover">
        <thead class="table-light">
          <tr>
            <th>Date</th>
            <th>Action</th>
            <th>Quantity</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>19 May, 2021 - 10:10 AM</td>
            <td>Stock Added</td>
            <td>+500</td>
          </tr>
          <tr>
            <td>18 May, 2021 - 3:12 PM</td>
            <td>Stock Removed</td>
            <td>-100</td>
          </tr>
        </tbody>
      </table> 
    </div>
  </div>
 