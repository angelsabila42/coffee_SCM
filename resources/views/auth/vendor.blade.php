@extends('layouts.app')

@section('page-title', 'Vendor Registration')


@section('content')
<div class="container">
               @if(session('message'))
                     <div class="alert alert-danger">
                     {{ session('message') }}
                     </div>
                 @endif
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
                            <label for="name" class="col-md-4 text-bold card-title text-md-end">FULL NAME</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ Auth::user()->name  }}" required autocomplete="name">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                         <div class="row mb-3">
                            <label for="email" class="card-title col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ Auth::user()->email  }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 

                        <div class="row mb-3">
                            <label for="phone_number " class="card-title col-md-4 col-form-label text-md-end">{{ __('Phone number') }}</label>

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
                            <label for="street" class="card-title col-md-4 col-form-label text-md-end">{{ __('street') }}</label>

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
                            <label for="city" class="card-title col-md-4 col-form-label text-md-end">{{ __('city') }}</label>

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
                           <label for="region" class="card-title col-md-4 col-form-label text-md-end">{{ __('Region') }}</label>
                        <select name="region" id="" class="form-control w-50">
                             <option value="">Select Region</option>
                            <option value="north">Northern</option>
                             <option value="south">Southern</option>
                              <option value="west">Western</option>
                               <option value="east">Eastern</option>
                        </select>
                        </div>
                        
                         <div class="row mb-3">
                            <label for="Bank_account" class="card-title col-md-4 col-form-label text-md-end">{{ __('Bank Account') }}</label>

                            <div class="col-md-6">
                                <input id="Bank_account" type="text" class="form-control @error('Bank_account') is-invalid @enderror" name="Bank_account" value="{{ old('Bank_account') }}" required autocomplete="Bank_account">

                                @error('Bank_account')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                         <div class="row mb-3">
                            <label for="Account_holder" class="card-title col-md-4 col-form-label text-md-end">{{ __('account_Holder') }}</label>

                            <div class="col-md-6">
                                <input id="Account_holder" type="text" class="form-control @error('Account_holder') is-invalid @enderror" name="Account_holder" value="{{ old('Account_holder') }}" required autocomplete="Account_holder">

                                @error('Account_holder')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 

                         <div class="row mb-3">
                            <label for="Bank_name" class="card-title col-md-4 col-form-label text-md-end">{{ __('Bank_name') }}</label>

                            <div class="col-md-6">
                                <input id="Bank_name" type="text" class="form-control @error('Bank_name') is-invalid @enderror" name="Bank_name" value="{{ old('Bank_name') }}" required autocomplete="Bank_name">

                                @error('Bank_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                      
                    
                        <div class="card-header" style="color:rgb(29, 14, 14); background-color:rgb(236, 245, 245);">{{ __('UPLOAD ATTACHMENTS (Pdf format only)') }}</div>
                           <div style="display: flex">
                             <label for="UCDA" class="card-title f-sm col-md-4 form-label text-md-end">{{ __('certificate from UCDA') }}</label>

                             <input id="UCDA" type="file" class="form-control @error('UCDA') is-invalid @enderror" name="UCDA" >
                            </div>
                          <div style="display: flex">
                             <label for="financial_statement" class="card-title col-md-4 col-form-label text-md-end">{{ __('financial_statement') }}</label>

                             <input id="financial_statement" type="file" class="form-control @error('financial_statement') is-invalid @enderror" name="financial_statement" >
                       
                            </div> 

                         <div style="display: flex">
                          <label for="national_id" class="card-title col-md-4 col-form-label text-md-end">{{ __('national_id') }}</label>

                         <input id="national_id" type="file" class="form-control @error('national_id') is-invalid @enderror" name="national_id"  >
                         </div>
                       
                         <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary w-50 rounded-pill mt-3">
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

