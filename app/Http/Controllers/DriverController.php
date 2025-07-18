<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transporter;
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
        $transporters = Transporter::all();
        return view('drivers.create', compact('transporters'));
    }
       

    function store2(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable',
            'address' => 'nullable',
            'transporter_company' => 'required',
            'transporter_company_id' => 'required|exists:transporters,id',
            'license_number' => 'nullable',
            'vehicle_number' => 'nullable',
            'experience' => 'nullable|numeric|min:0',
        ]);
        
        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;
        $user->address = $validated['address'] ?? null;
        $user->transporter_company = $validated['transporter_company'];
        $user->transporter_company_id = $validated['transporter_company_id'];
        $user->license_number = $validated['license_number'] ?? null;
        $user->vehicle_number = $validated['vehicle_number'] ?? null;
        $user->experience = $validated['experience'] ?? null;
        $user->role = 'driver';
        $user->password = bcrypt('password');
        $user->is_available = true;
        $user->save();
        
        return redirect()->route('drivers.create')->with('success', 'Driver added successfully to ' . $validated['transporter_company'] . '!');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable',
            'address' => 'nullable',
            'transporter_company' => 'required',
            'transporter_company_id' => 'required|exists:transporters,id',
            'license_number' => 'nullable',
            'vehicle_number' => 'nullable',
            'experience' => 'nullable|numeric|min:0',
        ]);
        
        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;
        $user->address = $validated['address'] ?? null;
        $user->transporter_company = $validated['transporter_company'];
        $user->transporter_company_id = $validated['transporter_company_id'];
        $user->license_number = $validated['license_number'] ?? null;
        $user->vehicle_number = $validated['vehicle_number'] ?? null;
        $user->experience = $validated['experience'] ?? null;
        $user->role = 'driver';
        $user->password = bcrypt('password');
        $user->is_available = true;
        $user->save();
        
        return redirect()->route('drivers.index')->with('success', 'Driver added successfully to ' . $validated['transporter_company'] . '!');
    }

    public function show($id)
    {
        $driver = User::where('role', 'driver')->findOrFail($id);
        return view('drivers.show', compact('driver'));
    }

    public function edit($id)
    {
        $driver = User::where('role', 'driver')->findOrFail($id);
        $transporters = Transporter::all();
        return view('drivers.edit', compact('driver', 'transporters'));
    }

    public function update(Request $request, $id)
    {
        $driver = User::where('role', 'driver')->findOrFail($id);
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$driver->id,
            'phone' => 'nullable',
            'address' => 'nullable',
            'transporter_company' => 'required',
            'transporter_company_id' => 'required|exists:transporters,id',
            'license_number' => 'nullable',
            'vehicle_number' => 'nullable',
            'experience' => 'nullable|numeric|min:0',
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
