<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\VendorResource;
use App\Http\Resources\V1\VendorCollection;
use Services\V1\VendorQuery;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class VendorController extends Controller
{
       
//   'name',
//         'email',
//        'email',
//         'phone_number',
//         'street',
//         'city',

    public function index(Request $request){

        $filter = new VendorQuery();
        $queryItems = $filter->Transform($request);

        if(count($queryItems) == 0){
            return new VendorCollection(Vendor::paginate());
        }else{
             return new VendorCollection(Vendor::where($queryItems)->paginate());
        }
    }

    public function show(Vendor $vendor){
        return new VendorResource($vendor);
    }

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
  }
  

    # code...

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
    

    Vendor::create($validated);

     $fields = collect($validated)->only([
        'name','email','password'
         ])->toArray();

    User::create($fields);
    return redirect()->back();

    }
}

   
    
    
    
  
