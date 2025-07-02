<?php


namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\IncomingOrder;
use App\Models\Payment;
use App\Models\User;
use App\Models\importerModel;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ImporterModelController extends Controller
{


    public function payments(){
        return view('importer_payments');
    }



     

    public function index(){
          $orders = IncomingOrder::paginate(6);


          $ordersSent = IncomingOrder::count();
          $pending = IncomingOrder::where('status', 'Pending')->count();
          $inTransit = IncomingOrder::where('status', 'in transit')->count();
          $delivered = IncomingOrder::where('status', 'Delievered')->count();
        return view ('importer_dashboard', compact('orders', 'ordersSent', 'pending', 'inTransit', 'delivered'));
    }
   
    public function transactions(){

        $invoices = Invoice::paginate(5);
          $payments = Payment::paginate(5);
    return view('importer_transactions', compact('invoices', 'payments'));
 }
      
    
 public function importer(){
    return view('auth.importer');
 }


    
public function destroy(IncomingOrder $order)
{
    $order->delete();
    return redirect()->back()->with('success', 'Order deleted successfully!');
}

     public function store(Request $req){

    $validated = $req->validate([
        'name' => 'required',
        'email' => 'required|email|unique:importer_models,email',
        'password' => ['required','confirmed','min:8'],
        'country' => '',
        'address' => '',
        'phone_number' => 'required|regex:/^07[0-9]{8}$/',
         
        

    ]);   
     $validated['password'] = Hash::make($validated['password']);
    
    importerModel::create($validated);

    //  $fields = collect($validated)->only([
    //     'name','email','password'
    //      ])->toArray();

    // User::create($fields);
    // return redirect()->back();
    }
}
