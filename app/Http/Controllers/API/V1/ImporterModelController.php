<?php


namespace App\Http\Controllers\API\V1;
use App\Models\ImporterRecentActivities;
use App\Http\Controllers\Controller;
use App\Models\IncomingOrder;
use App\Models\Payment;
use App\Models\User;
use App\Models\importerModel;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ImporterModelController extends Controller
{
    

    public function payments(){
        return view('importer_payments');
    }
  
    // public function index(){
    //     $orders = IncomingOrder::paginate(10);

    public function index()
    {
            $user = Auth::user();    
          $importer = ImporterModel::where('email', $user->email)->first();
             $importerId = $importer->id;
         $orders2 = IncomingOrder::where('importer_model_id',$importerId )->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get();


    $orderData = $orders2->pluck('total');
     $months = $orders2->map(function ($order) {
        return Carbon::create($order->year, $order->month)->format('M Y'); // e.g. "Jan 2024"
    });

    
if ($importer) {
 
     $importerId = $importer->id;

    
    $orders = IncomingOrder::where('importer_model_id', $importerId)->paginate(10);
    $ordersSent = IncomingOrder::where('importer_model_id', $importerId)->count();
    $pending = IncomingOrder::where('importer_model_id', $importerId)->where('status', 'Pending')->count();
    $inTransit = IncomingOrder::where('importer_model_id', $importerId)->where('status', 'in transit')->count();
    $delivered = IncomingOrder::where('importer_model_id', $importerId)->where('status', 'Delivered')->count();
  return view('importer_dashboard', compact('orders', 'ordersSent', 'pending', 'inTransit', 'delivered', 'orderData', 'months', 'importer'))
        ->with('success', 'Welcome to your dashboard, ' . $importer->name . '!');
         }else{
        return redirect()->route('login')->with('error', 'No importer record found.');
           }
    }
   
public function transactions(){
    $user = Auth::user();
       $importerId = ImporterModel::where('email', $user->email)->first()->id;
       //dd($importerId);
         $invoices = Invoice::where('importer_id', $importerId)->paginate(10);
        //   $payments = Payment::where('importerID', $importerId)->paginate(10);
        $payments = Payment::where('importerID', $importerId)->paginate(10);
        $account_no = ImporterModel::where('email', $user->email)->first()->bank_account_no;
        $user = ImporterModel::where('email', $user->email)->first()->name;
        
     
       //  $invoices = Invoice::paginate(10);
    return view('importer_transactions', compact('invoices', 'payments', 'account_no', 'user'));
 }
      
    
 public function importer(){
    return view('auth.importer');
 }


    
public function destroy(IncomingOrder $order)
{   $orderId = $order->id;
    $order->delete();
      ImporterRecentActivities::create([
        'user_id' => Auth::id(),
        'title' => 'Order deleted',
        'type' => 'delete',
        'ip_address' => request()->ip(),
        'data' => [
            'order_id' => $orderId,
            'reason' => 'User manually deleted order'
        ]
    ]);
    return redirect()->back()->with('success', 'Order deleted successfully!');
}

     public function store(Request $req){

    $validated = $req->validate([
        'name' => 'required',
        'email' => 'required|email|unique:importer_models,email',
        //'password' => ['required','confirmed','min:8'],
        'country' => '',
        'address' => '',
        'phone_number' => 'required|regex:/^07[0-9]{8}$/',
           'Bank_account' => 'required',
         'Account_holder'=> 'required',
         'Bank_name' => 'required',
        
        

    ]);   
    // $validated['password'] = Hash::make($validated['password']);
    
    importerModel::create($validated);

     return redirect()->route('importer.dashboard')->with('success', 'registration successful');
    }

        public function showPayment($id)
{
    $payment = Payment::findOrFail($id); 
    return view('payments.ImporterPay', compact('payment'));
}


  public function showOrder($id)
{
    $order = IncomingOrder::findOrFail($id); 
    return view('payments.ImporterPay', compact('order'));
}



public function download($id)
{
    $payment = Payment::findOrFail($id);

    $pdf = Pdf::loadView('payments.ImporterPayDownload', compact('payment'));
    return $pdf->download('payment_details_' . $payment->invoice_id . '.pdf');
}
}
