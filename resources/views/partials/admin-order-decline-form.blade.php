
<form x-show= "showForm" x-cloak x-transition method="POST" action="{{route('in-order.store', ['order'=>$order->id])}}">
@csrf
<div class="form-group">
  <label for="declineReason">Reason for Decline:</label>
  <textarea
    rows="10"
    id="declineReason" 
    name="declineReason" 
    required
  >{{old('declineReason')}} </textarea>
  </div>
  <div>
    @error('declineReason') <span class="error">{{ $message }}</span> @enderror
 </div>

  <button type="submit" class="btn mt-3">Submit</button>

</form>
