<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Transporter;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Invoice;
use App\Models\Payment;

use App\Models\Notification;


class transporterController extends Controller
{
    
 public function dashboard(){
    // Get delivery statistics
    $activeDeliveries = Delivery::where('status', 'In Transit')->count();
    $pendingDeliveries = Delivery::where('status', 'Requested')->count();
    $completedDeliveries = Delivery::where('status', 'Delivered')->count();
    $delayedDeliveries = Delivery::where('status', 'Delayed')->orWhere('status', 'Cancelled')->count();
    
    // Get current deliveries for the table
    $currentDeliveries = Delivery::whereIn('status', ['Confirmed', 'In Transit', 'Accepted'])
                                ->orderBy('created_at', 'desc')
                                ->limit(10)
                                ->get();
    
    return view('transporter.dashboard', compact(
        'activeDeliveries', 'pendingDeliveries', 'completedDeliveries', 
        'delayedDeliveries', 'currentDeliveries'
    ));
 }
    
 public function transporter(){
    return view('auth.transporter');
 }    public function deliveries() {
        $user = Auth::user();
        
        // Get delivery counts for stats - using actual status values from your data
        $pendingConfirmation = Delivery::where('status', 'Pending')->count();
        $confirmed = Delivery::where('status', 'Confirmed')->count();
        $inTransit = Delivery::where('status', 'In Transit')->orWhere('status', 'Active')->count();
        $needsDriver = Delivery::where('status', 'Confirmed')->where(function($query) {
            $query->whereNull('assigned_driver')->orWhere('assigned_driver', '');
        })->count();
        
        // Get confirmed deliveries that need driver assignment
        $confirmedDeliveries = Delivery::where('status', 'Confirmed')->get();
        
        // Get active deliveries (with drivers assigned)
        $activeDeliveries = Delivery::whereIn('status', ['In Transit', 'Active'])
                                  ->where(function($query) {
                                      $query->whereNotNull('assigned_driver')
                                            ->where('assigned_driver', '!=', '');
                                  })->get();
        
        // Get available drivers
        $availableDrivers = User::where('role', 'driver')->get();
        
        return view('transporter.deliveries', compact(
            'pendingConfirmation', 'confirmed', 'inTransit', 'needsDriver',
            'confirmedDeliveries', 'activeDeliveries', 'availableDrivers'
        ));
    }
    
    public function drivers() {
        $drivers = User::where('role', 'driver')->paginate(10);
        return view('transporter.drivers.index', compact('drivers'));
    }
    
    public function createDriver() {
        return view('transporter.drivers.create');
    }
    
    public function storeDriver(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'license_number' => 'required|string|max:50',
            'vehicle_number' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'experience' => 'nullable|string',
        ]);
        
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'license_number' => $validated['license_number'],
            'vehicle_number' => $validated['vehicle_number'],
            'address' => $validated['address'],
            'experience' => $validated['experience'],
            'role' => 'driver',
            'password' => bcrypt('password123'), // Default password
        ]);
        
        return redirect()->route('transporter.drivers')->with('success', 'Driver added successfully!');
    }
    
    public function profile() {
        $user = Auth::user();
        $transporter = Transporter::where('email', $user->email)->first();
        
        // Get statistics
        $totalDeliveries = Delivery::count();
        $completedDeliveries = Delivery::where('status', 'Delivered')->count();
        $activeDrivers = User::where('role', 'driver')->count();
        
        return view('transporter.profile', compact(
            'transporter', 'totalDeliveries', 'completedDeliveries', 'activeDrivers'
        ));
    }
    
    public function assignDriver(Request $request, $deliveryId) {
        $validated = $request->validate([
            'driver_id' => 'nullable|exists:users,id',
            'manual_driver_name' => 'nullable|string|max:255',
            'eta' => 'nullable|date',
            'pickup_location' => 'nullable|string|max:255',
        ]);
        
        $delivery = Delivery::findOrFail($deliveryId);
        
        // Determine driver name
        if ($validated['driver_id']) {
            $driver = User::find($validated['driver_id']);
            $driverName = $driver->name;
        } else {
            $driverName = $validated['manual_driver_name'];
        }
        
        // Update delivery
        $delivery->update([
            'assigned_driver' => $driverName,
            'eta' => $validated['eta'],
            'pickup_location' => $validated['pickup_location'],
            'status' => 'In Transit'
        ]);
        
        return redirect()->route('transporter.deliveries')->with('success', 'Driver assigned successfully!');
    }
    
    public function markDelivered($deliveryId) {
        $delivery = Delivery::findOrFail($deliveryId);
        $delivery->update(['status' => 'Delivered']);
        
        return response()->json(['success' => true, 'message' => 'Delivery marked as completed']);
    }

 public function transactions(){

        $invoices = Invoice::paginate(10);
          $payments = Payment::paginate(10);
    return view('transporter_transactions', compact('invoices', 'payments'));
 }


    
     public function store(Request $req){

    $validated = $req->validate([
          'name' => 'required',
        'co_name' => 'required',
        'email' => 'required|email|unique:transporters,email',
        //'password' => ['required','confirmed','min:8'],
        'address' => '',
         'phone_number' => 'required|regex:/^07[0-9]{8}$/',
         'Bank_account' => 'required',
         'Account_holder'=> 'required',
         'Bank_name' => 'required',
        

    ]);   
    // $validated['password'] = Hash::make($validated['password']);
    
    transporter::create($validated);

   //   $fields = collect($validated)->only([
   //      'name','email','password'
   //       ])->toArray();

   //  User::create($fields);
     return redirect()->route('transporter.transactions')->with('success', 'registration successful');
    }
    
    public function updateProfile(Request $request) {
        $user = Auth::user();
        $transporter = Transporter::where('email', $user->email)->first();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'co_name' => 'required|string|max:255',
            'email' => 'required|email|unique:transporters,email,' . ($transporter ? $transporter->id : ''),
            'phone_number' => 'required|regex:/^07[0-9]{8}$/',
            'address' => 'nullable|string|max:255',
            'Bank_account' => 'required|string|max:255',
            'Account_holder' => 'required|string|max:255',
            'Bank_name' => 'required|string|max:255',
        ]);
        
        try {
            if ($transporter) {
                $transporter->update($validated);
            } else {
                $validated['email'] = $user->email;
                $validated['name'] = $user->name;
                Transporter::create($validated);
            }
            
            return redirect()->route('transporter.profile')->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('transporter.profile')->with('error', 'Failed to update profile. Please try again.');
        }
    }
    
    public function updateBanking(Request $request) {
        $user = Auth::user();
        $transporter = Transporter::where('email', $user->email)->first();
        
        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'bank_account' => 'required|string|max:255',
            'account_holder' => 'required|string|max:255',
        ]);
        
        if ($transporter) {
            $transporter->update([
                'Bank_name' => $validated['bank_name'],
                'Bank_account' => $validated['bank_account'],
                'Account_holder' => $validated['account_holder'],
            ]);
        } else {
            // Create new transporter record with banking info
            Transporter::create([
                'email' => $user->email,
                'name' => $user->name,
                'Bank_name' => $validated['bank_name'],
                'Bank_account' => $validated['bank_account'],
                'Account_holder' => $validated['account_holder'],
            ]);
        }
        
        return redirect()->route('transporter.profile')->with('success', 'Banking information updated successfully!');
    }
    
    public function editDriver($id) {
        $driver = User::where('role', 'driver')->findOrFail($id);
        return view('transporter.drivers.edit', compact('driver'));
    }
    
    public function updateDriver(Request $request, $id) {
        $driver = User::where('role', 'driver')->findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $driver->id,
            'phone' => 'nullable|string|max:20',
            'license_number' => 'required|string|max:50',
            'vehicle_number' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'experience' => 'nullable|string',
        ]);
        
        $driver->update($validated);
        
        return redirect()->route('transporter.drivers')->with('success', 'Driver updated successfully!');
    }
    
    public function destroyDriver($id) {
        $driver = User::where('role', 'driver')->findOrFail($id);
        $driver->delete();
        
        return redirect()->route('transporter.drivers')->with('success', 'Driver deleted successfully!');
    }
    
    public function deliveryDetails($deliveryId) {
        try {
            $delivery = Delivery::findOrFail($deliveryId);
            
            return response()->json([
                'success' => true,
                'delivery' => $delivery
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Delivery not found'
            ], 404);
        }
    }
    
}
