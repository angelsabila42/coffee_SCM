<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\VendorResource;
use App\Http\Resources\V1\VendorCollection;
use App\Filter\V1\VendorFilter;
use App\Http\Requests\V1\StoreVendorRequest;
use App\Http\Requests\V1\UpdateVendorRequest;
use App\Http\Resources\V1\VendorDropDownResource;
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

        $filter = new VendorFilter();
        $filterItems = $filter->Transform($request);

        $vendors = Vendor::where($filterItems)->paginate();

         return new VendorCollection($vendors->appends($request->query()));
    }

    public function show(Vendor $vendor){
        return new VendorResource($vendor);
    }

    /*public function store(StoreVendorRequest $request){
      return new VendorResource(Vendor::create($request->all()));

    }*/

    public function update(UpdateVendorRequest $request, Vendor $vendor){
      $vendor->update($request->all());
    }

    public function dropdown(){
      return VendorDropDownResource::collection(Vendor::select('id', 'name')->get());
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

   
    
    
    
  
