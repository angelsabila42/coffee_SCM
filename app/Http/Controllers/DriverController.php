<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = User::where('role', 'driver')->paginate(10);
        return view('drivers.index', compact('drivers'));
    }

    public function create()
    {
        return view('drivers.create');
    }
       

    function store2(Request $request) {
    $validated = $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'phone' => 'nullable',
        'address' => 'nullable',
    ]);
    $user = new User();
    $user->name = $validated['name'];
    $user->email = $validated['email'];
    $user->phone = $validated['phone'] ?? null;
    $user->address = $validated['address'] ?? null;
    $user->role = 'driver';
    $user->password = bcrypt('password');
    $user->save();
    return redirect()->route('drivers.create')->with('success', 'Driver added successfully!');
}


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable',
            'address' => 'nullable',
        ]);
        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;
        $user->address = $validated['address'] ?? null;
        $user->role = 'driver';
        $user->password = bcrypt('password');
        $user->save();
        return redirect()->route('drivers.index')->with('success', 'Driver added successfully!');
    }

    public function show($id)
    {
        $driver = User::where('role', 'driver')->findOrFail($id);
        return view('drivers.show', compact('driver'));
    }

    public function edit($id)
    {
        $driver = User::where('role', 'driver')->findOrFail($id);
        return view('drivers.edit', compact('driver'));
    }

    public function update(Request $request, $id)
    {
        $driver = User::where('role', 'driver')->findOrFail($id);
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$driver->id,
            'phone' => 'nullable',
            'address' => 'nullable',
        ]);
        $driver->update($validated);
        return redirect()->route('drivers.index')->with('success', 'Driver updated successfully!');
    }

    public function destroy($id)
    {
        $driver = User::where('role', 'driver')->findOrFail($id);
        $driver->delete();
        return redirect()->route('drivers.index')->with('success', 'Driver deleted successfully!');
    }
}
