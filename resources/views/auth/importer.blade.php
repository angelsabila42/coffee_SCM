@extends('layouts.app')

@section('page-title', 'Importer Registration')



@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                 <div class="card-header"  style="color:rgb(29, 14, 14); background-color:rgb(236, 245, 245); font-size:larger;
                border-radius:10px;">{{ __('IMPORTER REGISTRATION') }}</div>
                <div class="card-header">{{ __('Register here') }}</div>
                     {{-- <div class="card-header">{{ __('BUSINESS INFORMATION') }}</div> --}}

                <div class="card-body">
                    <form method="POST" action="{{ route('store.importer') }}" >
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="card-title col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

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
                                <input id="email" type="email" class=" form-control @error('email') is-invalid @enderror" name="email" value="{{ Auth::user()->email  }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                         <div class="row mb-3">
                            <label for="country" class="card-title col-md-4 col-form-label text-md-end">{{ __('Country') }}</label>

                            <div class="col-md-6">
                                <input id="country" type="text" class="form-control @error('country') is-invalid @enderror" name="country" value="{{ old('country') }}" required autocomplete="country">

                                @error('country')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="phone_number" class="card-title col-md-4 col-form-label text-md-end">{{ __('Phone number') }}</label>

                            <div class="col-md-6">
                                <input id="phone_number"  type="number" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" required autocomplete="phone_number">

                                @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="address" class="card-title col-md-4 col-form-label text-md-end">{{ __('address') }}</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="address">

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
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

