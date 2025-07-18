<?php

namespace App\Http\Controllers;

use App\Models\inventory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
     function add(Request $request){
         $inventory = new inventory();
         $inventory->coffee_type = $request->coffee_type;
         $inventory->grade = $request->grade;
         $inventory->warehouse_name = $request->warehouse_name;
         $inventory->quantity = $request->quantity;
         $inventory->threshold = $request->threshold;
         $inventory->last_updated = $request->last_updated;
         $result= $inventory->save();

        if($request){
            echo "stock added";
        }else{
            echo "stock not added";
        }
       
    }
    public function mut(Request $request){
 $search = $request->input('search');
//   dd($search);

        $inventories = inventory::query()->when($search, function ($query, $search){
           $query->where('coffee_type', 'like', "%{$search}%")
            ->orwhere('warehouse_name', 'like', "%{$search}%")
            ->orwhere('grade', 'like', "%{$search}%");

        })
        ->paginate(5)
        ->appends(['search' => $search]);
        return view('inventory', compact('inventories', 'search'));
    }
    public function ern(){
        $inventories = inventory::paginate(5);//fetch all rows
        return view('inventory',compact('inventories'));
    }
    public function destroy($id){
        $inventory = inventory::findOrFail($id);
        $inventory->delete();
        return 
        redirect()->back()->with('success', 'Record deleted successfully.');
    }
     public function alber(){
        $inventories = inventory::paginate(5);
        $belowMinimumCount = inventory::where('quantity', '<', 'threshold')->count();
        $totalStock = inventory::sum('quantity');
        $totalWarehouses = inventory::distinct('warehouse_name')->count('warehouse_name');

        // calculate total stock
        $robustaStock = inventory::where('coffee_type', 'Robusta')->sum('quantity');
        $arabicaStock = inventory::where('coffee_type', 'Arabica')->sum('quantity');

        return view('inventory', compact('belowMinimumCount', 'totalStock', 'totalWarehouses', 'inventories', 'robustaStock', 'arabicaStock',));
    }
    public function geor($id){
     $inventory = inventory::findOrFail($id);
     return view('stock', compact('inventory'));
}
}
