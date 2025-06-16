<?php

namespace App\Http\Controllers;

use App\Models\vendor;
use Illuminate\Http\Request;

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
         'phone_number' => 'required|numeric|digits:10',
        

    ]);   
    
    vendor::create($validated);
    return redirect()->back();
    }
}
