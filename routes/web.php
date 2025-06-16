<?php

use Illuminate\Support\Facades\Route;
use app\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('auth.login');
});

//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/orders', function () {
    return view('orders');
});
Route::get('/order', function () {
    return view('order');
});

?>  