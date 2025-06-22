<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
class vendorController extends Controller
{

   public function pdfValidation(Request $request){
     $pdf =$request->file('document');
      $pdf= base64_encode(file_get_contents($pdf->getRealPath()
    ));
   $res = Http::Post('http://localhost:8081/api/verify',[
   
    'pdf' => $pdf,
   ]);
   return $res->body();
}

  public function register(Request $request){
     $pdf =$request->file('document');
      $pdf= base64_encode(file_get_contents($pdf->getRealPath()
    ));

   $res = Http::Post('http://localhost:8081/api/verify',[
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'password' => $request->input('password'),
        'confpassword' => $request->input('password_confirmation'),

    'pdf' => $pdf,
   ]);
   return $res->body();
  

    # code...
   }

    public function store(Request $req){


      $validated = $req->validate([
         'name' => 'required',
        'email' => 'required|email|unique:vendor,email',
        'password' => ['required','confirmed','min:8'],
        'street' => '',
         'city' => '',
        'phone_number' => 'required|regex:/^07[0-9]{8}$/',
       // 'document' => 'required|file|mimes:pdf',
        

   ]);   
   $validated['password'] = Hash::make($validated['password']);
     $filepath = $req->file('document')->store('vendor_files','public');
    


    vendor::create($validated);
     $fields = collect($validated)->only([
        'name','email','password'
         ])->toArray();

    User::create($fields);
    return redirect()->back();

    }
}

   
    
    
    
  
