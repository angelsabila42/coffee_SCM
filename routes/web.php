<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\WorkAssignmentController;
use App\Http\Controllers\LeaveHistoryController;


//Route::get('/staff', [StaffController::class, 'staff'])->name('staff');

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/home/analytics', [AnalyticsController::class, 'index'])->name('analytics');
Route::resource('deliveries', DeliveryController::class);
Route::resource('invoices', InvoiceController::class);
Route::resource('payments', PaymentController::class);




//staff management routes
//Route::get('/staff', [StaffController::class, 'staff'])->name('staff_management.staff');
//Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
//Route::delete('/staff/{id}', [StaffController::class, 'destroy'])->name('staff.destroy');

Route::prefix('staff-management')->name('staff_management.')->group(function () {

    Route::get('/staff', [StaffController::class, 'staff'])->name('staff');
    Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
    Route::get('/staff/{staff}', [StaffController::class, 'show'])->name('staff.show');
    Route::put('/staff/{staff}', [StaffController::class, 'update'])->name('staff.update');
    Route::delete('/staff/{staff}', [StaffController::class, 'destroy'])->name('staff.destroy');


    // --- Work Assignment Routes ---
    Route::get('/work-assignments', [WorkAssignmentController::class, 'workassign'])->name('work-assignments.workassign'); // List all assignments
    Route::post('/work-assignments', [WorkAssignmentController::class, 'store'])->name('work-assignments.store'); // Store new assignment
    //  routes for update and delete 
    Route::put('/work-assignments/{workAssignment}', [WorkAssignmentController::class, 'update'])->name('work-assignments.update');
    Route::delete('/work-assignments/{workAssignment}', [WorkAssignmentController::class, 'destroy'])->name('work-assignments.destroy');
   
});

