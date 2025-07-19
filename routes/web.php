<?php

use App\Http\Controllers\Vendor\VendorReportsController;
use App\Http\Controllers\QAReportController;
use App\Http\Controllers\Vendor\VendorTransactionController;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\ProfileController;



use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\V1\VendorController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\transporterController;
use App\Http\Controllers\ImporterPaymentController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Vendor\VendorHomeController;

use App\Http\Controllers\WorkAssignmentController;
use App\Http\Controllers\LeaveHistoryController;

use App\Http\Controllers\authController;
use App\Http\Controllers\Auth\LoginController;

//use App\Http\Controllers\API\V1\VendorController; commented out by IAM wen merging


use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\AnnualCoffeeSaleAdmin;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;


use App\Http\Controllers\API\V1\ImporterModelController;
use App\Http\Controllers\API\V1\IncomingOrderController;
use App\Http\Controllers\ImporterOrderController;
use App\Http\Controllers\API\V1\AnnualCoffeeSaleAdminController;
use App\Http\Controllers\API\V1\ImporterDemandAdminController;
use Illuminate\Validation\Rules\Email;


use App\Http\Controllers\InventoryController;
use App\Http\Controllers\API\V1\OutgoingOrderController;
use App\Http\Controllers\API\V1\QuantityDemandController;
use App\Http\Controllers\API\V1\VendorClusterController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\UserAuditController;
use App\Http\Controllers\Vendor\VendorOrderController;
//use App\Models\inventory;

use App\Http\Controllers\InvoiceExportController;
use App\Http\Middleware\AutMiddleware;
use App\Models\QA;
use App\Models\Vendor;
use GuzzleHttp\Middleware;

use App\Http\Controllers\SaleReport;
use App\Http\Controllers\DeliveriesReport;

Route::get('/qa-vendor', function (QA $qa) {
    return view('qa.vendor-report', [
        'report' => $qa->all(),
    ]);
})->name('qa.vendor');

Route::get('/qa-vendor',[QAReportController::class, 'store'])->name('qa.store');

//transporter transactions

Route::get('/payments/{id}', [transporterController::class, 'showPayment'])->name('TransPayments.show');

// PesaPal payment routes for importers
Route::middleware('auth')->prefix('importer/payment')->group(function () {
    Route::post('/initiate', [ImporterPaymentController::class, 'initiatePayment'])->name('importer.payment.initiate');
    Route::get('/form', [ImporterPaymentController::class, 'showPaymentForm'])->name('pesapal.form');
    Route::post('/pesapal-iframe', [ImporterPaymentController::class, 'processPesapalForm'])->name('pesapal.iframe');
    Route::get('/callback', [ImporterPaymentController::class, 'paymentCallback'])->name('importer.payment.callback');
    Route::post('/callback', [ImporterPaymentController::class, 'paymentCallback']);
    Route::get('/status/{merchantReference}', [ImporterPaymentController::class, 'paymentStatus'])->name('importer.payment.status');
    Route::get('/unpaid-orders', [ImporterPaymentController::class, 'getUnpaidOrders'])->name('importer.payment.unpaid-orders');
    Route::get('/debug', function() {
        $user = Auth::user();
        $importer = \App\Models\ImporterModel::where('email', $user->email)->first();
        $orders = \App\Models\IncomingOrder::where('importer_model_id', $importer ? $importer->id : 0)->get();
        return response()->json([
            'user' => $user,
            'importer' => $importer,
            'orders' => $orders,
            'total_orders' => $orders->count()
        ]);
    })->name('importer.payment.debug');
    Route::get('/create-test-orders', function() {
        $user = Auth::user();
        $importer = \App\Models\ImporterModel::where('email', $user->email)->first();
        
        if (!$importer) {
            return response()->json(['error' => 'No importer found']);
        }
        
        // Create 3 test orders
        $orders = [];
        for ($i = 1; $i <= 3; $i++) {
            $order = \App\Models\IncomingOrder::create([
                'orderID' => 'KX' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'quantity' => rand(100, 500),
                'coffeeType' => ['Arabica', 'Robusta', 'Liberica'][rand(0, 2)],
                'status' => ['Requested', 'Pending'][rand(0, 1)],
                'deadline' => now()->addDays(30),
                'grade' => ['AA', 'A', 'B'][rand(0, 2)],
                'destination' => ['Kenya', 'Tanzania', 'Rwanda'][rand(0, 2)],
                'importer_model_id' => $importer->id
            ]);
            $orders[] = $order;
        }
        
        return response()->json(['message' => 'Created 3 test orders', 'orders' => $orders]);
    })->name('importer.payment.create-test-orders');
});

// Additional payment routes for vendor and transporter payments
Route::middleware('auth')->prefix('payments')->group(function () {
    Route::get('/vendor/form', [PaymentController::class, 'showVendorPaymentForm'])->name('payments.vendor.form');
    Route::get('/transporter/form', [PaymentController::class, 'showTransporterPaymentForm'])->name('payments.transporter.form');
    Route::get('/form', [ImporterPaymentController::class, 'showPaymentForm'])->name('payments.form');
});

   
Route::get('/alpine',function(){
    return view('alpine');
});
Route::get('/phpinfo', function () {
    phpinfo();
});

// Route::get('/dashboard', function () {
//     return view('Dashboards.home');
// })->middleware(['auth', 'verified'])->name('dashboard');



require __DIR__.'/auth.php';


// custom auth routes


//Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


      Route::get('/adminDashboard', function () {
          return view('Dashboards.admin');
      })->middleware('admin')->name('admin.dashboard');




Route::middleware('auth')->group(function()
{             
                        Route::get('/welcome', function () {
                         return view('welcome');
                    });

                                
                            Route::prefix('staff-management')->name('staff_management.')->group(function ()
                             {

                                Route::get('/staff', [StaffController::class, 'staff'])->name('staff');
                                Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
                                Route::get('/staff/{staff}', [StaffController::class, 'show'])->name('staff.show');
                                Route::put('/staff/{staff}', [StaffController::class, 'update'])->name('staff.update');
                                Route::patch('/staff/{staff}/status', [StaffController::class, 'updateStatus'])->name('staff.status');
                                Route::post('/staff/{staff}/profile-picture', [StaffController::class, 'updateProfilePicture'])->name('staff.updateProfilePicture');
                                Route::delete('/staff/{staff}', [StaffController::class, 'destroy'])->name('staff.destroy');


                                // --- Work Assignment Routes ---
                                Route::get('/workassignment', [WorkAssignmentController::class, 'workassign'])->name('workassignment.workassign'); // List all assignments
                                Route::post('/workassignment', [WorkAssignmentController::class, 'store'])->name('workassignment.store'); // Store new assignment
                                Route::get('/workassignment/{assignment_id}', [WorkAssignmentController::class, 'edit'])->name('workassignment.edit'); // Edit specific assignment
                                Route::put('/workassignment/{workAssignment}', [WorkAssignmentController::class, 'update'])->name('workassignment.update');
                                Route::delete('/workassignment/{workAssignment}', [WorkAssignmentController::class, 'destroy'])->name('workassignment.destroy');
                                // --- Leave History Routes ---
                                Route::get('/leavehistory', [LeaveHistoryController::class, 'leavehistory'])->name('leavehistory.leavehistory'); // List all leave history
                                Route::post('/leavehistory', [LeaveHistoryController::class, 'store'])->name('leavehistory.store'); // Store new leave record
                                Route::get('/leavehistory/{leaveHistory}', [LeaveHistoryController::class, 'show'])->name('leavehistory.show'); // Show specific leave record
                                Route::put('/leavehistory/{leaveHistory}', [LeaveHistoryController::class, 'update'])->name('leavehistory.update'); // Update leave record
                                Route::delete('/leavehistory/{leaveHistory}', [LeaveHistoryController::class, 'destroy'])->name('leavehistory.destroy'); // Delete leave record
                                Route::patch('/leavehistory/{leaveHistory}/status', [LeaveHistoryController::class, 'updateStatus'])->name('leavehistory.status');

                            });



                    // Route::get('/home/dashboard', [App\Http\Controllers\HomeController::class, 'index']);
                         
                    Route::get('/inventory', function () {
                        return view('inventory');
                    });
                    Route::get('/form_modal', function () {
                        return view('form_modal');
                    });


                                                
                     Route::get('/home', function () {
                         return view('welcome');
                     })->name('index');
                  //  Route::get('/', [HomeController::class, 'index'])->name('index');

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
                    Route::get('/pesapal-transaction/{id}/details', [PaymentController::class, 'getPesapalTransactionDetails'])->name('admin.pesapal.transaction.details');

                    /*Delivery Routes*/
                    Route::resource('deliveries', DeliveryController::class);

                    /*User Audit Routes*/
                    Route::get('/user-audits', [UserAuditController::class, 'index'])->name('admin.user-audits.index');
                    Route::get('/user-audits/{id}', [UserAuditController::class, 'show'])->name('admin.user-audits.show');


                                    
        Route::get('/home/dashboard', function(){
            return view('Dashboards.home');
        });


         Route::post("/java",[VendorController::class, 'pdfValidation'])-> name('java.store');
     
        //Route::get("/java",[VendorController::class, 'store'])-> name('java'); 

       Route::get('/reg/vendor', [VendorController::class, 'vendor'])->name('vendor');
        //Route::get('/reg/transporter', [transporterController::class, 'transporter'])->name('transporter');

        Route::get('/reg/importer', [ImporterModelController::class, 'importer'])->name('importer');
        //Route::post('/reg/vendor', [VendorController::class, 'store'])->name('store.vendor');
        Route::get('/reg/transporter', [transporterController::class, 'transporter'])->name('transporter');
      
        Route::post('/reg/vendor', [VendorController::class, 'store'])->name('store.vendor');


        Route::post('/reg/transporter', [transporterController::class, 'store'])->name('store.transporter');
        Route::post('/reg/importer', [ImporterModelController::class, 'store'])->name('store.importer');

           
    /*Dashboard routes*/
   Route::get('/admin-home', [HomeController::class, 'index'])->name('admin.home');



   

        /*Dashboard routes*/
        Route::get('/home', [HomeController::class, 'index'])->name('home');

        /*Analytics route*/
        Route::get('/home/analytics', [AnalyticsController::class, 'index'])->name('analytics');

    /*Analytics routes*/
    Route::get('/admin-home/analytics', [AnalyticsController::class, 'index'])->name('analytics');
    Route::get('/import-annual-coffee-sales', [AnnualCoffeeSaleAdminController::class, 'importCsv']);
    Route::get('/import-importer-demand', [ImporterDemandAdminController::class, 'importCsv']);
    Route::get('/import-vendor-cluster', [VendorClusterController::class, 'importCsv']);
    Route::get('/import-demand-quantity', [QuantityDemandController::class, 'importCsv']);


   


        /*Report routes*/
        Route::get('/admin-home/report',[ReportController::class,'index'])->name('reports');
        Route::get('/vendor-home/report',[VendorReportsController::class,'index'])->name('vendor.reports');

        // QA Report Routes
        Route::prefix('qa-reports')->name('qa.')->group(function() {
            Route::get('/', [QAReportController::class, 'index'])->name('index');
            Route::get('/create', [QAReportController::class, 'create'])->name('create');
            Route::post('/', [QAReportController::class, 'store'])->name('store');
            Route::get('/{report}', [QAReportController::class, 'show'])->name('show');
            Route::delete('/{report}', [QAReportController::class, 'destroy'])->name('destroy');
        });

        /*Order Routes*/
        Route::get('/admin-home/orders', [OrderController::class, 'index'])->name('order.index');
        Route::post('/admin-home/orders',[OutgoingOrderController::class, 'store'])->name('out-order.store');
        Route::get('/admin-home/orders/{order}/Outgoing', [OutgoingOrderController::class, 'viewOutOrder'])->name( 'orders.view-vendor-order');
        Route::get('/vendor-home/orders/{order}', [OutgoingOrderController::class, 'viewVendorOrder'])->name('vendor.order.show');
        Route::post('/vendor-home/orders/{order}', [OutgoingOrderController::class, 'store'])->name('vendor.order.store');
        Route::get('/vendor-home/orders/{order}/download', [OutgoingOrderController::class, 'downloadVendor'])->name('vendor.order.download');
        Route::get('/admin-home/orders/{order}/download/Outgoing', [OutgoingOrderController::class, 'downloadOutgoing'])->name('orders.view-vendor-order.download');
        Route::get('/admin-home/orders/{order}/Incoming', [IncomingOrderController::class, 'viewOrder'])->name('orders.view-importer-order');
        Route::post('/admin-home/orders/{order}', [IncomingOrderController::class, 'store'])->name('order.store-in');
        Route::get('/admin-home/orders/{order}/download/Incoming', [IncomingOrderController::class, 'download'])->name('order.download-in');
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
            Route::post('/chat/create', [ChatController::class, 'create'])->name('chat.create');
            Route::get('/chat/start/{participant}', [ChatController::class, 'start'])->name('chat.start');
            Route::get('/chat/{conversation}', [ChatController::class, 'show'])->name('chat.show');
            Route::post('/chat/{conversation}', [ChatController::class, 'store'])->name('chat.store');
            Route::get('/chat/{conversation}/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
            Route::post('/chat/{conversation}/mark-read', [ChatController::class, 'markAsRead'])->name('chat.markRead');

        Route::get('/stock', function () {
            return view('stock');
        });
        Route::get('/stock/{id}',[InventoryController::class,'geor'])->name('stock');

         Route::get('/editprofile', function () {
            return view('editprofile');
        });
       
        //editing profile
        Route::get('/editprofile',[ProfileController::class,'edit'])->name('editprofile');
        Route::post('/editprofile/update',[ProfileController::class,'update'])->name('editprofile.update');
        Route::post('/editprofile/password',[ProfileController::class,'changePassword'])->name('editprofile.password');
        // end of Arnest added



        Route::delete('/orders/{order}', [ImporterModelController::class, 'destroy'])->name('orders.destroy');

        Route::get('/invoices/{id}/export-csv', [InvoiceExportController::class, 'exportCsv'])->name('invoices.exportCsv');
        Route::get('/reports/payment/csv', [\App\Http\Controllers\ReportExportController::class, 'paymentCsv'])->name('reports.payment.csv');
        Route::get('/reports/receipt/{id}/csv', [\App\Http\Controllers\ReportExportController::class, 'receiptCsv'])->name('reports.receipt.csv');
        Route::get('/reports/delivery/csv', [\App\Http\Controllers\ReportExportController::class, 'deliveryCsv'])->name('reports.delivery.csv');
        Route::get('/reports/sales/csv', [\App\Http\Controllers\ReportExportController::class, 'salesCsv'])->name('reports.sales.csv');
        Route::get('/reports/qa/csv', [\App\Http\Controllers\ReportExportController::class, 'qaCsv'])->name('reports.qa.csv');

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
 

        // QA Reports

    Route::get('/qa-reports', [QAReportController::class, 'index'])->name('qa.index');
    Route::get('/qa-reports/create', [QAReportController::class, 'create'])->name('qa.create');
    Route::post('/qa-reports', [QAReportController::class, 'store'])->name('qa.store');
    Route::get('/qa-reports/{report}', [QAReportController::class, 'show'])->name('qa.show');
    Route::delete('/qa-reports/{report}', [QAReportController::class, 'destroy'])->name('qa.destroy');


});





//all vendor routes
Route::middleware(['vendor'])->group(function(){

// Vendor Transactions Dashboard
      Route::get('/transactions/vendor',[VendorTransactionController::class, 'index'] )->name('vendor.transactions');
      Route::get('/vendor-home', [VendorHomeController::class, 'index'])->name('vendor.home');

      //Route::post("/java",[VendorController::class, 'register'])-> name('java.store');
      Route::get('/qa-vendor',[VendorController::class, 'venReport'])->name('qa.vendor');

     Route::get('/qa-vendor/report/{reportID}', [VendorController::class,'venReportDetails'])->name('qa.vendor.report');

     
});



// //all importer routes
     Route::middleware('importer')->group(function(){
    
//importer  routes
    Route::get('/importer/dashboard', [ImporterModelController::class,'index'])->name('importer.dashboard');
    Route::get('/importer/transactions', [ImporterModelController::class,'transactions'])->name('importer.transactions');
    Route::delete('/orders/{order}', [ImporterModelController::class, 'destroy'])->name('orders.destroy');
    
Route::get('/payments/importer/{id}', [ImporterModelController::class, 'showPayment'])->name('ImporterPayments.show');
Route::get('/payments/importer/{id}/download', [ImporterModelController::class, 'download'])->name('ImporterPayments.download');


Route::get('/payments/{id}', [ImporterModelController::class, 'showOrder'])->name('ImporterOrders.show');


    });


//all transporter routes

                Route::middleware('transporter')->group(function(){

                // Transporter Dashboard
                Route::get('/transporter/dashboard', [transporterController::class, 'dashboard'])->name('transporter.dashboard');
                // Transporter Deliveries
                Route::get('/transporter/deliveries', [transporterController::class, 'deliveries'])->name('transporter.deliveries');
                // Transporter Drivers Management
                Route::get('/transporter/drivers', [transporterController::class, 'drivers'])->name('transporter.drivers');
                Route::get('/transporter/drivers/create', [transporterController::class, 'createDriver'])->name('transporter.drivers.create');
                Route::post('/transporter/drivers', [transporterController::class, 'storeDriver'])->name('transporter.drivers.store');
                Route::get('/transporter/drivers/{id}/edit', [transporterController::class, 'editDriver'])->name('transporter.drivers.edit');
                Route::put('/transporter/drivers/{id}', [transporterController::class, 'updateDriver'])->name('transporter.drivers.update');
                Route::delete('/transporter/drivers/{id}', [transporterController::class, 'destroyDriver'])->name('transporter.drivers.destroy');
                // Delivery Assignment Routes
                Route::put('/transporter/deliveries/{delivery}/assign-driver', [transporterController::class, 'assignDriver'])->name('transporter.deliveries.assign-driver');
                Route::post('/transporter/deliveries/{delivery}/mark-delivered', [transporterController::class, 'markDelivered'])->name('transporter.deliveries.mark-delivered');
                Route::get('/transporter/deliveries/{delivery}/details', [transporterController::class, 'deliveryDetails'])->name('transporter.deliveries.details');
                // Transporter Profile
                Route::get('/transporter/profile', [transporterController::class, 'profile'])->name('transporter.profile');
                Route::put('/transporter/profile', [transporterController::class, 'updateProfile'])->name('transporter.profile.update');
                Route::put('/transporter/banking', [transporterController::class, 'updateBanking'])->name('transporter.banking.update');
                // Legacy routes
                // Transporter Delivery Dashboard
                Route::get('/deliveries/transporter', [transporterController::class, 'deliveries'])->name('deliveries.transporter');

                // //transporter transactions
                Route::get('/transporter/transactions', [transporterController::class,'transactions'])->name('transporter.transactions');
                
                Route::get('/transporter',[DeliveryController::class,'merc']);
                        Route::delete('/transporter/{id}',[DeliveryController::class,'dismiss'])->name('transporter.dismiss');
                Route::get('/transporter', function () {
                            return view('transporter');
                        });
                        Route::get('/payments/{id}/download', [transporterController::class, 'download'])->name('payments.download');

                Route::get('/payments/{id}', [transporterController::class, 'showPayment'])->name('TransPayments.show');

                    

                });
//notification routes
Route::post('/notifications/mark-as-read', function () {
    Auth::user()->unreadNotifications->markAsRead();
    return response()->json(['success' => true]);
})->middleware('auth');

// Staff profile picture routes
Route::post('/staff/{id}/profile-picture', [StaffController::class, 'updateProfilePicture'])->name('staff.updateProfilePicture');
Route::get('/staff/{id}/details', [StaffController::class, 'getStaffDetails'])->name('staff.get-details');

Route::get('/SalesReportDetails/{id}', [SaleReport::class, 'show'])->name('sales-details');
Route::get('/DeliveryReportDetails/{id}', [DeliveriesReport::class, 'show'])->name('delivery-details');


