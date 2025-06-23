<?php

namespace App\Http\Controllers;
 use App\Models\staff;
//use Illuminate\Foundation\Auth\User;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class staffController extends Controller
{



 public function staff(){
    return view('auth.staff');
 }


    
     public function store(Request $req){

    $validated = $req->validate([
        'name' => 'required',
        'email' => 'required|email|unique:staff,email',
        'password' => ['required','confirmed','min:8'],
        'role' => '',
         'status' => '',
          'phone_number' => 'required|regex:/^07[0-9]{8}$/',
         
        

    ]);   
     $validated['password'] = Hash::make($validated['password']);
    
    staff::create($validated);

    $fields = collect($validated)->only([
        'name','email','password'
         ])->toArray();

    User::create($fields);
    return redirect()->back();
    }
}
