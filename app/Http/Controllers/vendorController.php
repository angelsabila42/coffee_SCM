<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

use function Livewire\store;

class vendorController extends Controller
{


 public function vendor(){
        return view('auth.vendor');
    }




   public function pdfValidation(Request $request){


     $financialStatement = $request->file('financial_statement');
    $nationalId = $request->file('national_id');
    $ucda = $request->file('UCDA');

    // file encoding
    $financialStatementBase64 = base64_encode(file_get_contents($financialStatement->getRealPath()));
    $nationalIdBase64 = base64_encode(file_get_contents($nationalId->getRealPath()));
    $ucdaBase64 = base64_encode(file_get_contents($ucda->getRealPath()));

    // java_data_validation
    $java_data_validation = [
        'userName' => $request->input('name'),
        'id' => $nationalIdBase64,
        'idname' => $nationalId->getClientOriginalName(),
        'financialStatus' => $financialStatementBase64,
        'financialStatusName' => $financialStatement->getClientOriginalName(),
       'ucdaCertificate' => $ucdaBase64,
       'ucdaCertificateName' => $ucda->getClientOriginalName(),
    ];
     $res = Http::post('http://localhost:8081/api/verify', $java_data_validation);

      

        if ($res->successful()) {

          if (str_contains($res->body(),'successful')) {

      
      
          $this->store($request);
          

             return response()->json(['message' => 'Vendor registered successfully']);

           // return response()->json(['message' => 'PDF is valid'], 200);
      } else {
        // return $res->body();
          return response()->json(['validation failed' => 'please upload valid documents '], 400);
      }
      
      # code...
      
    }

      else {
            return response()->json(['message' => $res->body()], 500);  
        }

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
         // $filepath = $req->file('financial_statement')->store('vendor_files','public');
        


        vendor::create($validated);
/*$fields = collect($validated)->only([
              'name','email','password'
              ])->toArray();

          User::create($fields);*/
        return redirect()->back();
        return response()->json(['message' => 'Vendor registered successfully']);

        }
    }


// end of vendorController.php   
    
    
    
  
