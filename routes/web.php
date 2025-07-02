<?php

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\ProfileController;



use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\V1\VendorController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\transporterController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\WorkAssignmentController;
use App\Http\Controllers\LeaveHistoryController;

use App\Http\Controllers\authController;
use App\Http\Controllers\Auth\LoginController;

//use App\Http\Controllers\API\V1\VendorController; commented out by IAM wen merging


use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;


use App\Http\Controllers\ImporterModelController;
use Illuminate\Validation\Rules\Email;


use App\Http\Controllers\InventoryController;
//use App\Models\inventory;

use App\Http\Controllers\InvoiceExportController;

Route::get('/home', function () {
    return view('index');
})->name('index');
Route::get('/', [HomeController::class, 'index'])->name('index');

Route::get('/', function () {
    return view('auth.login');
});



Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::get('/home/analytics', [AnalyticsController::class, 'index'])->name('analytics');
Route::get('/home/report',[ReportController::class,'index'])->name('reports');

// Transporter Delivery Dashboard
Route::get('/deliveries/transporter', function () {
    return view('deliveries.transporter-dashboard');
})->name('deliveries.transporter');

Route::resource('deliveries', DeliveryController::class);
Route::get('/home/orders', [OrderController::class, 'index'])->name('orders');
Route::resource('invoices', InvoiceController::class);
Route::resource('payments', PaymentController::class);


Route::get('/alpine',function(){
    return view('alpine');
});


Route::get('/inventory', function () {
    return view('inventory');
});
Route::get('/form_modal', function () {
    return view('form_modal');
});

Route::get('/dashboard', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


// custom auth routes

Route::post('/reg/vendor', [VendorController::class, 'store'])->name('store.vendor');

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/home/dashboard', function(){
    return view('home');
});


Route::prefix('staff-management')->name('staff_management.')->group(function () {

    Route::get('/staff', [StaffController::class, 'staff'])->name('staff');
    Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
    Route::get('/staff/{staff}', [StaffController::class, 'show'])->name('staff.show');
    Route::put('/staff/{staff}', [StaffController::class, 'update'])->name('staff.update');
    Route::delete('/staff/{staff}', [StaffController::class, 'destroy'])->name('staff.destroy');


    // --- Work Assignment Routes ---
    Route::get('/workassignment', [WorkAssignmentController::class, 'workassign'])->name('workassignment.workassign'); // List all assignments
    Route::post('/workassignment', [WorkAssignmentController::class, 'store'])->name('workassignment.store'); // Store new assignment
    Route::get('/workassignment/{assignment_id}', [WorkAssignmentController::class, 'edit'])->name('workassignment.edit'); // Edit specific assignment
    //  routes for update and delete 
    Route::put('/workassignment/{workAssignment}', [WorkAssignmentController::class, 'update'])->name('workassignment.update');
    Route::delete('/workassignment/{workAssignment}', [WorkAssignmentController::class, 'destroy'])->name('workassignment.destroy');
   

    // --- Leave History Routes ---
    Route::get('/leavehistory', [LeaveHistoryController::class, 'leavehistory'])->name('leavehistory.leavehistory'); // List all leave history
    Route::post('/leavehistory', [LeaveHistoryController::class, 'store'])->name('leavehistory.store'); // Store new leave record
    Route::get('/leavehistory/{leaveHistory}', [LeaveHistoryController::class, 'show'])->name('leavehistory.show'); // Show specific leave record
    Route::put('/leavehistory/{leaveHistory}', [LeaveHistoryController::class, 'update'])->name('leavehistory.update'); // Update leave record
    Route::delete('/leavehistory/{leaveHistory}', [LeaveHistoryController::class, 'destroy'])->name('leavehistory.destroy'); // Delete leave record
});


// auth routes...

Route::get('/reg', [authController::class, 'category'])->name('category');
Route::get('/reg/vendor', [authController::class, 'vendor'])->name('vendor');
Route::get('/reg/transporter', [transporterController::class, 'transporter'])->name('transporter');
Route::get('/reg/others', [authController::class, 'others'])->name('others');
Route::get('/reg/importer', [ImporterModelController::class, 'importer'])->name('importer');
Route::post('/reg', [authController::class, 'handleSelection'])->name('select.category');


//registration routes
Route::post('/reg/vendor', [VendorController::class, 'store'])->name('store.vendor');




Route::middleware('auth')->group(function(){
Route::get('/reg/vendor', [VendorController::class, 'vendor'])->name('vendor');
Route::get('/reg/transporter', [transporterController::class, 'transporter'])->name('transporter');

Route::get('/reg/importer', [ImporterModelController::class, 'importer'])->name('importer');
//Route::post('/reg/vendor', [VendorController::class, 'store'])->name('store.vendor');


Route::post('/reg/transporter', [transporterController::class, 'store'])->name('store.transporter');
Route::post('/reg/importer', [ImporterModelController::class, 'store'])->name('store.importer');



Route::get("/java",[VendorController::class, 'store'])-> name('java');
Route::post("/java",[VendorController::class, 'register'])-> name('java.store');
//inventory routes
// Route::post('form_modal',[InventoryController::class,'add']);//for adding data in the inventory table
Route::get('/inventory',[InventoryController::class,'ern']);//for fetching data from the table to the view table
Route::get('/inventory',[InventoryController::class,'mut']);//for the search input
Route::delete('/inventory/{id}',[InventoryController::class,'destroy'])->name('inventory.destroy');//for deleting a record
Route::get('/inventory',[InventoryController::class,'alber']);
Route::post('/inventory', [InventoryController::class, 'add'])->name('inventory.add');//for adding data in the inventory table

Route::get('/stock', function () {
    return view('stock');
});
Route::get('/stock/{id}',[InventoryController::class,'geor'])->name('stock');

Route::get('/transporter', function () {
    return view('transporter');
});

Route::post("/java",[VendorController::class, 'pdfValidation'])-> name('java.store');

// importer  routes
Route::get('/importer/dashboard', [ImporterModelController::class,'index'])->name('importer.dashboard');
Route::get('/importer/transactions', [ImporterModelController::class,'transactions'])->name('importer.transactions');

Route::delete('/orders/{order}', [ImporterModelController::class, 'destroy'])->name('orders.destroy');
});



//transporter transactions
Route::get('/transporter/transactions', [transporterController::class,'transactions'])->name('transporter.transactions');



// Transporter Delivery Dashboard
Route::get('/deliveries/transporter', function () {
    return view('deliveries.transporter-dashboard');
})->name('deliveries.transporter');

// Vendor Transactions Dashboard
Route::get('/transactions/vendor', function () {
    return view('transactions.vendor-dashboard');
})->name('transactions.vendor');

Route::get('/invoices/{id}/export-csv', [InvoiceExportController::class, 'exportCsv'])->name('invoices.exportCsv');
Route::get('/reports/payment/csv', [\App\Http\Controllers\ReportExportController::class, 'paymentCsv'])->name('reports.payment.csv');
Route::get('/reports/receipt/{id}/csv', [\App\Http\Controllers\ReportExportController::class, 'receiptCsv'])->name('reports.receipt.csv');

Route::get('/invoices/{id}/export-csv', [InvoiceExportController::class, 'exportCsv'])->name('invoices.exportCsv');
Route::get('/reports/payment/csv', [\App\Http\Controllers\ReportExportController::class, 'paymentCsv'])->name('reports.payment.csv');
Route::get('/reports/receipt/{id}/csv', [\App\Http\Controllers\ReportExportController::class, 'receiptCsv'])->name('reports.receipt.csv');

Route::get('/drivers/create', function () {
    return view('drivers.create');
})->name('drivers.create');

Route::get('/deliveries/{id}', function ($id) {
    $delivery = \App\Models\Delivery::findOrFail($id);
    return view('deliveries.show', compact('delivery'));
})->name('deliveries.show');

Route::post('/drivers/store', function (\Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'phone' => 'nullable',
        'address' => 'nullable',
    ]);
    $user = new \App\Models\User();
    $user->name = $validated['name'];
    $user->email = $validated['email'];
    $user->phone = $validated['phone'] ?? null;
    $user->address = $validated['address'] ?? null;
    $user->role = 'driver';
    $user->password = bcrypt('password');
    $user->save();
    return redirect()->route('drivers.create')->with('success', 'Driver added successfully!');
})->name('drivers.store');

Route::resource('drivers', \App\Http\Controllers\DriverController::class);


// --- Chat Routes (must be authenticated) ---
Route::middleware('auth')->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat');
    Route::get('/chat/{conversation}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{conversation}', [ChatController::class, 'store'])->name('chat.store');
    Route::get('/chat/{conversation}/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/chat/create', [ChatController::class, 'create'])->name('chat.create');
});

// Session keep-alive route for AJAX ping (prevents session expiry during chat)
Route::get('/keep-alive', function () {
    return response()->json(['alive' => true]);
})->middleware('auth');
