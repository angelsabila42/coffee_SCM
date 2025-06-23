<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\VendorResource;
use App\Http\Resources\V1\VendorCollection;
use Services\V1\VendorQuery;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Support\Facades\Hash;
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
    public function store(Request $req){

    $validated = $req->validate([
        'name' => 'required',
        'email' => 'required|email|unique:vendor,email',
        'password' => ['required','confirmed','min:8'],
        'street' => '',
         'city' => '',
        'phone_number' => 'required|regex:/^07[0-9]{8}$/',
         'document' => 'required|file|mimes:pdf',
        

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
