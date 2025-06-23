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
         $inventory->status = $request->status;
         $inventory->last_updated = $request->last_updated;
         $result= $inventory->save();

        if($request){
            echo "stock added";
        }else{
            echo "student not added";
        }
       
    }
    public function mut(Request $request){
 $search = $request->input('search');
  //dd($search);
        $inventories = \App\Models\inventory::query()->when($search, function ($query, $search){
           $query->whereRaw('LOWER(coffee_type) LIKE ?',  ["%{search}%"])
            ->orwhereRaw('LOWER(warehouse_name) LIKE ?',  ["%{search}%"])
            ->orwhereRaw('LOWER(grade) LIKE ?',  ["%{search}%"]);
        })
        ->get();
        return view('inventory', compact('inventories', 'search'));
    }
    public function ern(){
        $inventories = inventory::all();//fetch all rows
        return view('inventory',compact('inventories'));
    }
    public function destroy($id){
        $inventory = inventory::findOrFail($id);
        $inventory->delete();
        return 
        redirect()->back()->with('success', 'Record deleted successfully.');
    }
     public function alber(){
        $inventories = inventory::all();
        $belowMinimumCount = inventory::where('status', 'low')->count();
        $totalStock = inventory::sum('quantity');
        $totalWarehouses = inventory::distinct('warehouse_name')->count('warehouse_name');
        return view('inventory', compact('belowMinimumCount', 'totalStock', 'totalWarehouses', 'inventories'));
    }
    public function geor($id){
     $inventory = inventory::findOrFail($id);
     return view('stock', compact('inventory'));
}
}
