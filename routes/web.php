<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('auth.login');
});

//Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/home/analytics', [AnalyticsController::class, 'index'])->name('analytics');
Route::get('/home/report',[ReportController::class,'index'])->name('reports');
Route::resource('deliveries', DeliveryController::class);
Route::resource('invoices', InvoiceController::class);
Route::resource('payments', PaymentController::class);

Route::get('/orders', function () {
    return view('orders');
});
Route::get('/order', function () {
    return view('order');
});
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



