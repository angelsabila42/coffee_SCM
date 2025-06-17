<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\authController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\vendorController;
use App\Http\Controllers\staffController;
use App\Http\Controllers\transporterController;
use App\Http\Controllers\ImporterModelController;
use App\Models\transporter;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::get('/home/analytics', [AnalyticsController::class, 'index'])->name('analytics');



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