<?php
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\vendorController;
use App\Http\Controllers\staffController;
use App\Http\Controllers\authController;
use App\Http\Controllers\transporterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImporterModelController;
use Illuminate\Validation\Rules\Email;

Route::get('/vendor', function () {
    return view('auth.vendor');
})->name('vendor');

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
Route::get('/inventory', function () {
    return view('inventory');
});

Route::get('/dashboard', function () {
    return view('analytics');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// custom auth routes
Route::post('/reg/vendor', [vendorController::class, 'store'])->name('store.vendor');
Route::get('/reg', [authController::class, 'category'])->name('category');
Route::get('/reg/vendor', [authController::class, 'vendor'])->name('vendor');
Route::get('/reg/staff', [staffController::class, 'staff'])->name('staff');
Route::get('/reg/transporter', [transporterController::class, 'transporter'])->name('transporter');
Route::get('/reg/others', [authController::class, 'others'])->name('others');
Route::get('/reg/importer', [ImporterModelController::class, 'importer'])->name('importer');
Route::post('/reg', [authController::class, 'handleSelection'])->name('select.category');

Route::post('/reg/vendor', [vendorController::class, 'store'])->name('store.vendor');
Route::post('/reg/staff', [staffController::class, 'store'])->name('store.staff');
Route::post('/reg/transporter', [transporterController::class, 'store'])->name('store.transporter');
Route::post('/reg/importer', [ImporterModelController::class, 'store'])->name('store.importer');


Route::get("/java",[vendorController::class, 'store'])-> name('java');
Route::post("/java",[vendorController::class, 'register'])-> name('java.store');