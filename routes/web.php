<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\authController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\vendorController;


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::get('/home/analytics', [AnalyticsController::class, 'index'])->name('analytics');



// auth routes...
Route::get('/reg', [authController::class, 'category'])->name('category');
Route::get('/reg/vendor', [authController::class, 'vendor'])->name('vendor');
Route::get('/reg/others', [authController::class, 'others'])->name('others');
Route::post('/reg', [authController::class, 'handleSelection'])->name('select.category');

//vendor routes
Route::post('/reg/vendor', [vendorController::class, 'store'])->name('store.vendor');