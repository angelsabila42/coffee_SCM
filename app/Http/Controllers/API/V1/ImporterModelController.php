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
use Illuminate\Support\Facades\Auth;

class ImporterModelController extends Controller
{
    

    public function payments(){
        return view('importer_payments');
    }



     
    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->middleware('importer');
    // }
    public function index(){
   $user = Auth::user();     
 // Logged-in user
$importer = ImporterModel::where('email', $user->email)->first();

if ($importer) {
    $importerId = $importer->id;

    
    $orders = IncomingOrder::where('importer_model_id', $importerId)->paginate(10);
    $ordersSent = IncomingOrder::where('importer_model_id', $importerId)->count();
    $pending = IncomingOrder::where('importer_model_id', $importerId)->where('status', 'Pending')->count();
    $inTransit = IncomingOrder::where('importer_model_id', $importerId)->where('status', 'in transit')->count();
    $delivered = IncomingOrder::where('importer_model_id', $importerId)->where('status', 'Delivered')->count();

    return view('importer_dashboard', compact('orders', 'ordersSent', 'pending', 'inTransit', 'delivered'));
} else {
    
    return redirect()->route('login')->with('error', 'No importer record found.');
}
       }
   
    public function transactions(){
    $user = Auth::user();
    $importerId = ImporterModel::where('email', $user->email)->id;

        $invoices = Invoice::/*where('importer_model_id', $importerId)->*/paginate(10);
          $payments = Payment::where('importerID', $importerId)->paginate(10);
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
