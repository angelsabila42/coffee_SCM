<?php

use App\Http\Controllers\Vendor\VendorReportsController;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\ProfileController;



use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\V1\VendorController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\transporterController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Vendor\VendorHomeController;

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


use App\Http\Controllers\API\V1\ImporterModelController;
use App\Http\Controllers\ImporterOrderController;
use Illuminate\Validation\Rules\Email;


use App\Http\Controllers\InventoryController;
use App\Http\Controllers\API\V1\OutgoingOrderController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\Vendor\VendorOrderController;

//use App\Models\inventory;

use App\Http\Controllers\InvoiceExportController;
use App\Http\Middleware\AutMiddleware;
use GuzzleHttp\Middleware;


Route::get('/alpine',function(){
    return view('alpine');
});


// Route::get('/dashboard', function () {
//     return view('Dashboards.home');
// })->middleware(['auth', 'verified'])->name('dashboard');



require __DIR__.'/auth.php';


// custom auth routes


//Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');








Route::middleware('auth')->group(function()
{   

                                
                            Route::prefix('staff-management')->name('staff_management.')->group(function ()
                             {

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
                            });


                                                
                    Route::get('/inventory', function () {
                        return view('inventory');
                    });
                    Route::get('/form_modal', function () {
                        return view('form_modal');
                    });


                                                
                    Route::get('/home', function () {
                        return view('index');
                    })->name('index');
                    Route::get('/', [HomeController::class, 'index'])->name('index');

                    Route::get('/', function () {
                        return view('auth.login');
                    });

                    // Transporter Delivery Dashboard
                    Route::get('/deliveries/transporter', function () {
                        return view('deliveries.transporter-dashboard');
                    })->name('deliveries.transporter');

                    Route::resource('deliveries', DeliveryController::class);

                    /*transactions Routes*/
                    Route::resource('invoices', InvoiceController::class);
                    Route::resource('payments', PaymentController::class);

                    /*Delivery Routes*/
                    Route::resource('deliveries', DeliveryController::class);


                                    
        Route::get('/home/dashboard', function(){
            return view('Dashboards.home');
        });


       Route::get('/reg/vendor', [VendorController::class, 'vendor'])->name('vendor');
        //Route::get('/reg/transporter', [transporterController::class, 'transporter'])->name('transporter');

        Route::get('/reg/importer', [ImporterModelController::class, 'importer'])->name('importer');
        //Route::post('/reg/vendor', [VendorController::class, 'store'])->name('store.vendor');

      
        Route::post('/reg/vendor', [VendorController::class, 'store'])->name('store.vendor');


        Route::post('/reg/transporter', [transporterController::class, 'store'])->name('store.transporter');
        Route::post('/reg/importer', [ImporterModelController::class, 'store'])->name('store.importer');

           

    // --- Leave History Routes ---
    Route::get('/leavehistory', [LeaveHistoryController::class, 'leavehistory'])->name('leavehistory.leavehistory'); // List all leave history
    Route::post('/leavehistory', [LeaveHistoryController::class, 'store'])->name('leavehistory.store'); // Store new leave record
    Route::get('/leavehistory/{leaveHistory}', [LeaveHistoryController::class, 'show'])->name('leavehistory.show'); // Show specific leave record
    Route::put('/leavehistory/{leaveHistory}', [LeaveHistoryController::class, 'update'])->name('leavehistory.update'); // Update leave record
    Route::delete('/leavehistory/{leaveHistory}', [LeaveHistoryController::class, 'destroy'])->name('leavehistory.destroy'); // Delete leave record


        /*Dashboard routes*/
        Route::get('/home', [HomeController::class, 'index'])->name('home');

        /*Analytics route*/
        Route::get('/home/analytics', [AnalyticsController::class, 'index'])->name('analytics');

        /*Report routes*/
        Route::get('/home/report',[ReportController::class,'index'])->name('reports');
        Route::get('/vendor-home/report',[VendorReportsController::class,'index'])->name('vendor.reports');


        /*Order Routes*/
        Route::get('/home/orders', [OrderController::class, 'index'])->name('orders');
        Route::post('/home/orders',[OutgoingOrderController::class, 'store'])->name('out-order.store');
        Route::get('/vendor-home/orders', [VendorOrderController::class, 'index'])->name('vendor.orders');
        Route::get('/importer-home/orders', [ImporterOrderController::class, 'index'])->name('importer.orders');

        // edit profile routes
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

  //inventory routes
        // Route::post('form_modal',[InventoryController::class,'add']);//for adding data in the inventory table
        Route::get('/inventory',[InventoryController::class,'ern']);//for fetching data from the table to the view table
        Route::get('/inventory',[InventoryController::class,'mut']);//for the search input
        Route::delete('/inventory/{id}',[InventoryController::class,'destroy'])->name('inventory.destroy');//for deleting a record
        Route::get('/inventory',[InventoryController::class,'alber']);
        Route::post('/inventory', [InventoryController::class, 'add'])->name('inventory.add');//for adding data in the inventory table

        // Chat Routes
        Route::get('/chat', [ChatController::class, 'index'])->name('chat');
            Route::get('/chat/{conversation}', [ChatController::class, 'show'])->name('chat.show');
            Route::post('/chat/{conversation}', [ChatController::class, 'store'])->name('chat.store');
            Route::get('/chat/{conversation}/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
            Route::post('/chat/create', [ChatController::class, 'create'])->name('chat.create');


        Route::get('/stock', function () {
            return view('stock');
        });
        Route::get('/stock/{id}',[InventoryController::class,'geor'])->name('stock');

         Route::get('/editprofile', function () {
            return view('editprofile');
        });
       
        //editing profile
        Route::get('/editprofile',[ProfileController::class,'edit'])->name('editprofile');
        Route::post('/editprofile',[ProfileController::class,'update'])->name('editprofile.update');
        Route::post('/editprofile',[ProfileController::class,'changePassword'])->name('editprofile.password');
        // end of Arnest added


        Route::post("/java",[VendorController::class, 'pdfValidation'])-> name('java.store');


        Route::delete('/orders/{order}', [ImporterModelController::class, 'destroy'])->name('orders.destroy');

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
        })->name('deliveries.show1');

        Route::post('/drivers/store', [DriverController::class,'store2'])->name('drivers.store2');

        Route::resource('drivers', DriverController::class);


        // Session keep-alive route for AJAX ping (prevents session expiry during chat)
        Route::get('/keep-alive', function () {
            return response()->json(['alive' => true]);
        });






});











//all vendor routes
Route::middleware(['vendor'])->group(function(){

// Vendor Transactions Dashboard
Route::get('/transactions/vendor',[VendorController::class, 'Transactions'] )->name('transactions.vendor');
Route::get('/vendor-home', [VendorHomeController::class, 'index'])->name('vendor.home');

        Route::get("/java",[VendorController::class, 'store'])-> name('java');
        Route::post("/java",[VendorController::class, 'register'])-> name('java.store');
      

});






//all importer routes
Route::middleware('importer')->group(function(){
    
// importer  routes
Route::get('/importer/dashboard', [ImporterModelController::class,'index'])->name('importer.dashboard');
Route::get('/importer/transactions', [ImporterModelController::class,'transactions'])->name('importer.transactions');


});








//all transporter routes

Route::middleware('transporter')->group(function(){

// Transporter Delivery Dashboard
Route::get('/deliveries/transporter', [transporterController::class, 'deliveries'])->name('deliveries.transporter');
Route::get('/reg/transporter', [transporterController::class, 'transporter'])->name('transporter');


//transporter transactions
Route::get('/transporter/transactions', [transporterController::class,'transactions'])->name('transporter.transactions');

 Route::get('/transporter',[DeliveryController::class,'merc']);
        Route::delete('/transporter/{id}',[DeliveryController::class,'dismiss'])->name('transporter.dismiss');
  Route::get('/transporter', function () {
            return view('transporter');
        });
     

});

