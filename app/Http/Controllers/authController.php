<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use function Laravel\Prompts\select;

class authController extends Controller
{
    public function category(){
        return view('auth.category');
    }

    
    public function others(){
        return view('auth.register');
    }
   

}
