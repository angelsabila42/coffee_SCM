@extends('layouts.app')
@section('content')
    
@include('payments.ImporterPaymentPartial')
 <div class="card d-flex flex-row flex-start ">
 <button class="btn btn-primary m-3" onclick="window.history.back()">Back</button>
<a href="{{ route('payments.download', $payment->id) }}" class="btn btn-info m-3">
    Download Payment Details
</a>
    </div>
@endsection

