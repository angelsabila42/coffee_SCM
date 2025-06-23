<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\authController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\API\V1\VendorController;
use App\Http\Controllers\transporterController;
use App\Http\Controllers\ImporterModelController;
use App\Models\transporter;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\OrderController;



Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::get('/home/analytics', [AnalyticsController::class, 'index'])->name('analytics');
Route::get('/home/report',[ReportController::class,'index'])->name('reports');
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

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// auth routes...
Route::get('/reg', [authController::class, 'category'])->name('category');
Route::get('/reg/vendor', [authController::class, 'vendor'])->name('vendor');
Route::get('/reg/transporter', [transporterController::class, 'transporter'])->name('transporter');
Route::get('/reg/others', [authController::class, 'others'])->name('others');
Route::get('/reg/importer', [ImporterModelController::class, 'importer'])->name('importer');
Route::post('/reg', [authController::class, 'handleSelection'])->name('select.category');

//registration routes
Route::post('/reg/vendor', [VendorController::class, 'store'])->name('store.vendor');
Route::post('/reg/transporter', [transporterController::class, 'store'])->name('store.transporter');
Route::post('/reg/importer', [ImporterModelController::class, 'store'])->name('store.importer');