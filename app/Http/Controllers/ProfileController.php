<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    // public function edit(Request $request): View
    // {
    //     return view('profile.edit', [
    //         'user' => $request->user(),
    //     ]);
    // }

    /**
     * Update the user's profile information.
     */
    // public function update(ProfileUpdateRequest $request): RedirectResponse
    // {
    //     $request->user()->fill($request->validated());

    //     if ($request->user()->isDirty('email')) {
    //         $request->user()->email_verified_at = null;
    //     }

    //     $request->user()->save();

    //     return Redirect::route('profile.edit')->with('status', 'profile-updated');
    // }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    public function edit(){
        $user = Auth::user();
        return view('editprofile', compact('user'));
    }
    public function update(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' =>'required|email|unique:users,email,' . Auth::id(),
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
        /** @var \App\Models\User $user */
        
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->hasFile('profile_picture')){
            if($user->profile_picture){
                Storage::delete('public/'. $user->profile_picture);
            }
            $file = $request->file('profile_picture');
            $path = $file->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }
        if($user->save()){
    session()->flash('success', 'Profile updated successfully.');
    return back();
} else {
    session()->flash('error', 'Failed to update profile. Please try again.');
    return back();
}

        
    }
    public function changePassword(Request $request){
        $request->validate([
            'current_password' => 'required',
           'new_password' => 'required|string|min:8|confirmed', 
        ]);
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if(!Hash::check($request->current_password, $user->password)){
            return back()->with('error', 'Current password is incorrect.');
        }
            $user->password = Hash::make($request->new_password);
              $user->save();
            return back()->with('success', 'Password changed successfully');

    }
}
