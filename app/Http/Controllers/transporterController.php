<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\transporter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Invoice;
use App\Models\Payment;

class transporterController extends Controller
{
    
 public function transporter(){
    return view('auth.transporter');
 }

 public function transactions(){

        $invoices = Invoice::paginate(5);
          $payments = Payment::paginate(5);
    return view('transporter_transactions', compact('invoices', 'payments'));
 }


    
     public function store(Request $req){

    $validated = $req->validate([
          'name' => 'required',
        'co_name' => 'required',
        'email' => 'required|email|unique:transporters,email',
        'password' => ['required','confirmed','min:8'],
        'address' => '',
         'phone_number' => 'required|regex:/^07[0-9]{8}$/',
         
        

    ]);   
     $validated['password'] = Hash::make($validated['password']);
    
    transporter::create($validated);

   //   $fields = collect($validated)->only([
   //      'name','email','password'
   //       ])->toArray();

   //  User::create($fields);
   //  return redirect()->back();
    }
}
