<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\MechanicController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VehicleController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // CRUD Pelanggan
    Route::resource('customers', CustomerController::class);

    // CRUD Kendaraan
    Route::resource('vehicles', VehicleController::class);

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->prefix('cashier')->group(function () {
    Route::get('/', [CashierController::class, 'index'])->name('cashier.index');
    Route::post('/assign/{id}', [CashierController::class, 'assignMechanic'])->name('cashier.assign');
    Route::get('/payment/{id}', [CashierController::class, 'showPaymentForm'])->name('cashier.payment');
    Route::post('/detail/add/{id}', [CashierController::class, 'addDetail'])->name('cashier.detail.add');
    Route::post('/complete/{id}', [CashierController::class, 'completeTransaction'])->name('cashier.complete');
    Route::delete('/detail/delete/{id}', [CashierController::class, 'deleteDetail'])->name('cashier.detail.delete');
    Route::get('/invoice/print/{id}', [CashierController::class, 'printInvoice'])->name('cashier.invoice.print');
    Route::get('/cashier/print/{id}', [CashierController::class, 'printInvoice'])->name('cashier.print');
    Route::get('/walk-in', [CashierController::class, 'createWalkIn'])->name('cashier.createWalkIn');
    Route::post('/walk-in', [CashierController::class, 'storeWalkIn'])->name('cashier.storeWalkIn');
});

Route::middleware(['auth'])->prefix('mechanic')->name('mechanic.')->group(function () {
    Route::get('/dashboard', [MechanicController::class, 'index'])->name('mechanic.index');
    Route::patch('/tasks/{id}/status', [MechanicController::class, 'updateStatus'])->name('mechanic.updateStatus');
});

require __DIR__.'/auth.php';