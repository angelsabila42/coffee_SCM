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
                    return redirect()->route('others');
                case 'importer':
                    return redirect()->route('others');
                case 'vendor':
                    return redirect('/reg/vendor');
                case 'transporter':
                    return redirect()->route('others');
                default:
                    return redirect('/reg'); // fallback
             }
            }

}
