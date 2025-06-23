<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\WorkAssignmentController;
use App\Http\Controllers\LeaveHistoryController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\authController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\vendorController;
use App\Http\Controllers\staffController;
use App\Http\Controllers\transporterController;
use App\Http\Controllers\ImporterModelController;
use App\Models\transporter;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InventoryController;
//use App\Models\inventory;




Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::get('/home/analytics', [AnalyticsController::class, 'index'])->name('analytics');
Route::get('/home/report',[ReportController::class,'index'])->name('reports');
Route::resource('deliveries', DeliveryController::class);
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::resource('invoices', InvoiceController::class);
Route::resource('payments', PaymentController::class);


Route::get('/order', function () {
    return view('order');
});
Route::get('/orders', function () {
    return view('orders');
});

Route::get('/inventory', function () {
    return view('inventory');
});
Route::get('/form_modal', function () {
    return view('form_modal');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

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
Route::get('/reg/staff', [staffController::class, 'staff'])->name('staff');
Route::get('/reg/transporter', [transporterController::class, 'transporter'])->name('transporter');
Route::get('/reg/others', [authController::class, 'others'])->name('others');
Route::get('/reg/importer', [ImporterModelController::class, 'importer'])->name('importer');
Route::post('/reg', [authController::class, 'handleSelection'])->name('select.category');

//registration routes
Route::post('/reg/vendor', [vendorController::class, 'store'])->name('store.vendor');
Route::post('/reg/staff', [staffController::class, 'store'])->name('store.staff');
Route::post('/reg/transporter', [transporterController::class, 'store'])->name('store.transporter');
Route::post('/reg/importer', [ImporterModelController::class, 'store'])->name('store.importer');

//inventory routes
Route::post('form_modal',[InventoryController::class,'add']);//for adding data in the inventory table
Route::get('/inventory',[InventoryController::class,'ern']);//for fetching data from the table to the view table
Route::get('/inventory',[InventoryController::class,'mut']);//for the search input
Route::delete('/inventory/{id}',[InventoryController::class,'destroy'])->name('inventory.destroy');//for deleting a record
Route::get('/inventory',[InventoryController::class,'alber']);

Route::get('/stock', function () {
    return view('stock');
});
Route::get('/stock/{id}',[InventoryController::class,'geor'])->name('stock');
