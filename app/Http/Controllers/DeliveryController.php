<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Delivery;
use Illuminate\Support\Str;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deliveries = Delivery::paginate(10); // Fetch deliveries with pagination
        return view('deliveries.index', compact('deliveries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Generate a new unique delivery_id for the form
        $newDeliveryId = 'NX_' . str_pad(Delivery::max('id') + 1, 3, '0', STR_PAD_LEFT);
        return view('deliveries.create', compact('newDeliveryId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'delivery_id' => 'required|unique:deliveries,delivery_id|max:255',
            'pickup_location' => 'nullable|string|max:255',
            'dispatch_date_time' => 'nullable|date',
            'delivery_destination' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'coffee_type' => 'required|string|max:255',
            'coffee_grade' => 'nullable|string|max:255',
            'status' => 'required|string|max:255',
            'assigned_driver' => 'nullable|string|max:255',
            'eta' => 'nullable|date',
            'date_ordered' => 'required|date',
        ]);

        Delivery::create($validated);

        return redirect()->route('deliveries.index')->with('success', 'Delivery request created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Delivery $delivery)
    {
        return view('deliveries.show', compact('delivery'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Delivery $delivery)
    {
        return view('deliveries.edit', compact('delivery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Delivery $delivery)
    {
        $validated = $request->validate([
            'pickup_location' => 'nullable|string|max:255',
            'dispatch_date_time' => 'nullable|date',
            'delivery_destination' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'coffee_type' => 'required|string|max:255',
            'coffee_grade' => 'nullable|string|max:255',
            'status' => 'required|string|max:255',
            'assigned_driver' => 'nullable|string|max:255',
            'eta' => 'nullable|date',
            'date_ordered' => 'required|date',
        ]);

        $delivery->update($validated);

        return redirect()->route('deliveries.index')->with('success', 'Delivery request updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Delivery $delivery)
    {
        $delivery->delete();

        return redirect()->route('deliveries.index')->with('success', 'Delivery request deleted successfully!');
    }
 public function merc()
    {
     $deliveries = Delivery::all();
     $pending = Delivery::where('status', 'pending')->count();
     $completed = Delivery::where('status', 'completed')->count();
     $delayed = Delivery::where('status', 'delayed')->count();
     $active = Delivery::where('status', 'active')->count();
        return view('transporter', compact('pending', 'completed', 'delayed', 'active', 'deliveries', ));
    }
      public function dismiss($id){
        $delivery = Delivery::findOrFail($id);
        $delivery->delete();
        return 
        redirect()->back()->with('success', 'Record deleted successfully.');
    } 
}
