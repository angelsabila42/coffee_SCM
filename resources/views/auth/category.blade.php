  @extends('layouts.auth')
  @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"
                style="color:white; background-color:rgb(127, 127, 226);font-size:larger;
                border-radius:10px;">{{ __('SELECT CATEGORY') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('select.category') }}">
                        @csrf

                        <div class="row mb-6">
                            <label for="staff" class="col-md-4 col-form-label text-md-end">{{ __('staff') }}</label>

                            <div class="col-md-6">
                                <input id="staff" type="radio" value="staff" name="category"  >

                              
                            </div>
                             <label for="importer" class="col-md-4 col-form-label text-md-end">{{ __('importer') }}</label>

                            <div class="col-md-6">
                                <input id="importer" type="radio" value="importer" class="" name="category"  >

                              
                            </div>
                             <label for="vendor" class="col-md-4 col-form-label text-md-end">{{ __('vendor') }}</label>

                            <div class="col-md-6">
                                <input id="vendor" type="radio" value="vendor" class="" name="category"  >

                              
                            </div>
                            <label for="transporter" class="col-md-4 col-form-label text-md-end">{{ __('Transporter') }}</label>

                            <div class="col-md-6">
                                <input id="transporter" type="radio" value="transporter" class="" name="category"  >
                            </div>
                             <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection