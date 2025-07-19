
<form x-show= "showForm" x-cloak x-transition method="POST" action="{{route('order.store-in', ['order'=>$order->id])}}">
@csrf
<div class="form-group">
  <label for="declineReason" class="font-weight-bold">Reason for Decline:</label>
  <textarea
    rows="180"
    cols="200"
    id="declineReason" 
    name="declineReason" 
    required
  >{{old('declineReason')}} </textarea>
  </div>
  <div>
    @error('declineReason') <span class="error">{{ $message }}</span> @enderror
 </div>

  <button type="submit" class="btn mt-3 save">Submit</button>

</form>
