@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="color:rgb(29, 14, 14); background-color:rgb(236, 245, 245); font-size:larger;
                border-radius:10px;">{{ __('VENDOR REGISTRATION FORM') }}</div>
                     {{-- <div class="card-header">{{ __('BUSINESS INFORMATION') }}</div> --}}

                <div class="card-body">
                    <form method="POST" action="{{ route('java.store') }}" enctype="multipart/form-data">
                        @csrf

                     

                         <div class="card-header" style="color:rgb(29, 14, 14); background-color:rgb(236, 245, 245);">{{ __('CONTACT DETAILS') }}</div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Full name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                         <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="phone_number" class="col-md-4 col-form-label text-md-end">{{ __('Phone number') }}</label>

                            <div class="col-md-6">
                                <input id="phone_number"  placeholder="start with 07" type="number" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" required autocomplete="phone_number">

                                @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="street" class="col-md-4 col-form-label text-md-end">{{ __('street') }}</label>

                            <div class="col-md-6">
                                <input id="street" type="text" class="form-control @error('street') is-invalid @enderror" name="street" value="{{ old('street') }}" required autocomplete="street">

                                @error('street')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="city" class="col-md-4 col-form-label text-md-end">{{ __('city') }}</label>

                            <div class="col-md-6">
                                <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autocomplete="city">

                                @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        

                        
                            <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="card-header" style="color:rgb(29, 14, 14); background-color:rgb(236, 245, 245);">{{ __('UPLOAD ATTACHMENTS (Pdf format only)') }}</div>
                           <div style="display: flex">
                             <label for="UCDA" class="col-md-4 col-form-label text-md-end">{{ __('certificate from UCDA') }}</label>

                             <input id="UCDA" type="file" class="form-control @error('UCDA') is-invalid @enderror" name="UCDA" >
                            </div>
                          <div style="display: flex">
                             <label for="financial_statement" class="col-md-4 col-form-label text-md-end">{{ __('financial_statement') }}</label>

                             <input id="financial_statement" type="file" class="form-control @error('financial_statement') is-invalid @enderror" name="financial_statement" >
                       
                            </div>

                         <div style="display: flex">
                          <label for="national_id" class="col-md-4 col-form-label text-md-end">{{ __('national_id') }}</label>

                         <input id="national_id" type="file" class="form-control @error('national_id') is-invalid @enderror" name="national_id"  >
                         </div>
                       
                         <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

