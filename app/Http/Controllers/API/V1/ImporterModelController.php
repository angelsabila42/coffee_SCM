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
  
    public function index()
    {
        $user = Auth::user();    
        $importer = ImporterModel::where('email', $user->email)->first();
        
        if (!$importer) {
            return redirect()->route('login')->with('error', 'No importer record found.');
        }
        
        $importerId = $importer->id;
        
        // Get orders and statistics for this specific importer
        $orders = IncomingOrder::where('importer_model_id', $importerId)->paginate(10);
        $ordersSent = IncomingOrder::where('importer_model_id', $importerId)->count();
        $pending = IncomingOrder::where('importer_model_id', $importerId)->where('status', 'Pending')->count();
        $inTransit = IncomingOrder::where('importer_model_id', $importerId)->where('status', 'in transit')->count();
        $delivered = IncomingOrder::where('importer_model_id', $importerId)->where('status', 'Delivered')->count();

        // Generate chart data for the last 12 months
        $months = [];
        $orderData = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M Y');
            
            $monthlyOrders = IncomingOrder::where('importer_model_id', $importerId)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            
            $orderData[] = $monthlyOrders;
        }

        return view('importer_dashboard', compact('orders', 'ordersSent', 'pending', 'inTransit', 'delivered', 'importer', 'orderData', 'months'))
            ->with('success', 'Welcome to your dashboard, ' . $importer->name . '!');
    }
   
public function transactions(){
    $user = Auth::user();
    $importer = ImporterModel::where('email', $user->email)->first();
    
    if (!$importer) {
        return redirect()->route('login')->with('error', 'No importer record found.');
    }
    
    $importerId = $importer->id;
    
    $invoices = Invoice::where('importer_id', $importerId)->paginate(10);
    $payments = Payment::where('importerID', $importerId)->paginate(10);
    
    // Get account details from the importer record
    $account_no = $importer->Bank_account;
    $account_holder = $importer->Account_holder;
    $bank_name = $importer->Bank_name;
    
    // Debug: Check orders for this importer
    $allOrders = IncomingOrder::where('importer_model_id', $importerId)->get();
    $requestedOrders = IncomingOrder::where('importer_model_id', $importerId)->where('status', 'Requested')->get();
    $pendingOrders = IncomingOrder::where('importer_model_id', $importerId)->where('status', 'Pending')->get();
    
    \Log::info('Debug transactions page:', [
        'user' => $user->email,
        'importer_id' => $importerId,
        'total_orders' => $allOrders->count(),
        'requested_orders' => $requestedOrders->count(),
        'pending_orders' => $pendingOrders->count(),
        'all_orders_statuses' => $allOrders->pluck('status', 'id')->toArray()
    ]);
    
    return view('importer_transactions', compact('invoices', 'payments', 'account_no', 'account_holder', 'bank_name', 'importer'));
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
        'country' => '',
        'address' => '',
        'phone_number' => 'required|regex:/^07[0-9]{8}$/',
           'Bank_account' => 'required',
         'Account_holder'=> 'required',
         'Bank_name' => 'required',
        
        

    ]);   
    
    importerModel::create($validated);

     return redirect()->route('importer.dashboard')->with('success', 'registration successful');
    }

        public function showPayment($id)
{
    $payment = Payment::findOrFail($id); 
    return view('payments.ImporterPay', compact('payment'));
}

public function download($id)
{
    $payment = Payment::findOrFail($id);

    $pdf = Pdf::loadView('payments.ImporterPayDownload', compact('payment'));
    return $pdf->download('payment_details_' . $payment->invoice_id . '.pdf');
}
}
