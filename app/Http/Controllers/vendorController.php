<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class vendorController extends Controller
{

    
//   'name',
//         'email',
//        'email',
//         'phone_number',
//         'street',
//         'city',
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
    
    vendor::create($validated);
     $fields = collect($validated)->only([
        'name','email','password'
         ])->toArray();

    User::create($fields);
    return redirect()->back();
    }
}
