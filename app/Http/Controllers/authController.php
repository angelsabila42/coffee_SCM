<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use function Laravel\Prompts\select;

class authController extends Controller
{
    public function category(){
        return view('auth.category');
    }

     public function vendor(){
        return view('auth.vendor');
    }
    public function others(){
        return view('auth.register');
    }
    public function handleSelection(Request $request)
            {
                    $request->validate([
                    'category' => 'required|in:staff,importer,vendor,transporter',
                    ]);

            switch ($request->category)
              {
                case 'staff':
                    return redirect()->route('staff');
                case 'importer':
                    return redirect()->route('importer');
                case 'vendor':
                    return redirect('/reg/vendor');
                case 'transporter':
                    return redirect()->route('transporter');
                default:
                    return redirect('/reg'); 
             }
            }

}
