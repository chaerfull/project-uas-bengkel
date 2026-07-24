<?php

use App\Http\Controllers\CustomerBookingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\MechanicController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\CustomerAuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

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

/*
|--------------------------------------------------------------------------
| CASHIER
|--------------------------------------------------------------------------
*/

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

/*
|--------------------------------------------------------------------------
| MECHANIC
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('mechanic')->name('mechanic.')->group(function () {

    Route::get('/dashboard', [MechanicController::class, 'index'])->name('mechanic.index');

    Route::patch('/tasks/{id}/status', [MechanicController::class, 'updateStatus'])->name('mechanic.updateStatus');
});

/*
|--------------------------------------------------------------------------
| CUSTOMER PORTAL
|--------------------------------------------------------------------------
*/

Route::prefix('customer')->group(function () {

    Route::get('/login', [CustomerAuthController::class, 'showLogin'])
        ->name('customer.login');

    Route::post('/login', [CustomerAuthController::class, 'login'])
        ->name('customer.login.post');

    Route::get('/register', [CustomerAuthController::class, 'showRegister'])
        ->name('customer.register');

    Route::post('/register', [CustomerAuthController::class, 'register'])
        ->name('customer.register.post');

    Route::middleware('auth:customer')->group(function () {

        Route::get('/dashboard', [CustomerAuthController::class, 'dashboard'])
            ->name('customer.dashboard');

        // Kendaraan Customer
        Route::get('/vehicles', [VehicleController::class, 'customerIndex'])
            ->name('customer.vehicles.index');

        Route::get('/vehicles/create', [VehicleController::class, 'customerCreate'])
            ->name('customer.vehicles.create');

        Route::post('/vehicles', [VehicleController::class, 'customerStore'])
            ->name('customer.vehicles.store');

        // Booking Customer
        Route::get('/booking', [CustomerBookingController::class, 'create'])
            ->name('customer.booking.create');

        Route::post('/booking', [CustomerBookingController::class, 'store'])
            ->name('customer.booking.store');

        Route::get('/booking/history', [CustomerBookingController::class, 'history'])
            ->name('customer.booking.history');

        // Logout
        Route::post('/logout', [CustomerAuthController::class, 'logout'])
            ->name('customer.logout');
    });

});

require __DIR__.'/auth.php';