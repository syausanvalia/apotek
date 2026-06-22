<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApotekerController;
use App\Http\Controllers\PelangganController;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
    Route::post('/signup', [AuthController::class, 'signup']);
});

// Authenticated routes
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Admin routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Medicines
    Route::get('/medicines', [AdminController::class, 'medicines'])->name('medicines');
    Route::get('/medicines/create', [AdminController::class, 'createMedicine'])->name('medicines.create');
    Route::post('/medicines', [AdminController::class, 'storeMedicine'])->name('medicines.store');
    Route::get('/medicines/{id}/edit', [AdminController::class, 'editMedicine'])->name('medicines.edit');
    Route::put('/medicines/{id}', [AdminController::class, 'updateMedicine'])->name('medicines.update');
    Route::delete('/medicines/{id}', [AdminController::class, 'deleteMedicine'])->name('medicines.delete');
    Route::get('/expired-medicines', [AdminController::class, 'expiredMedicines'])->name('expired-medicines');
    
    // Apotekers
    Route::get('/apotekers', [AdminController::class, 'apotekers'])->name('apotekers');
    Route::get('/apotekers/create', [AdminController::class, 'createApoteker'])->name('apotekers.create');
    Route::post('/apotekers', [AdminController::class, 'storeApoteker'])->name('apotekers.store');
    Route::get('/apotekers/{id}/edit', [AdminController::class, 'editApoteker'])->name('apotekers.edit');
    Route::put('/apotekers/{id}', [AdminController::class, 'updateApoteker'])->name('apotekers.update');
    Route::delete('/apotekers/{id}', [AdminController::class, 'deleteApoteker'])->name('apotekers.delete');
    
    // Suppliers
    Route::get('/suppliers', [AdminController::class, 'suppliers'])->name('suppliers');
    
    // Purchases
    Route::get('/purchases', [AdminController::class, 'purchases'])->name('purchases');
    
    // Sales Report
    Route::get('/sales-report', [AdminController::class, 'salesReport'])->name('sales-report');
});

// Apoteker routes
Route::middleware(['auth'])->prefix('apoteker')->name('apoteker.')->group(function () {
    Route::get('/dashboard', [ApotekerController::class, 'dashboard'])->name('dashboard');
    
    // Medicines
    Route::get('/medicines', [ApotekerController::class, 'medicines'])->name('medicines');
    Route::get('/medicines/search', [ApotekerController::class, 'searchMedicines'])->name('medicines.search');
    Route::get('/medicines/create', [ApotekerController::class, 'createMedicine'])->name('medicines.create');
    Route::post('/medicines', [ApotekerController::class, 'storeMedicine'])->name('medicines.store');
    Route::get('/medicines/{id}/edit', [ApotekerController::class, 'editMedicine'])->name('medicines.edit');
    Route::put('/medicines/{id}', [ApotekerController::class, 'updateMedicine'])->name('medicines.update');
    Route::delete('/medicines/{id}', [ApotekerController::class, 'deleteMedicine'])->name('medicines.delete');
    Route::get('/expired-medicines', [ApotekerController::class, 'expiredMedicines'])->name('expired-medicines');
    Route::delete('/expired-medicines/{id}', [ApotekerController::class, 'deleteExpiredMedicine'])->name('expired-medicines.delete');
    
    // Sales
    Route::get('/sales-history', [ApotekerController::class, 'salesHistory'])->name('sales-history');
    Route::get('/sales/create', [ApotekerController::class, 'createSale'])->name('sales.create');
    Route::post('/sales', [ApotekerController::class, 'storeSale'])->name('sales.store');
    Route::get('/sales/{id}', [ApotekerController::class, 'viewSale'])->name('sales.show');
});

// Pelanggan routes
Route::middleware(['auth'])->prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::get('/dashboard', [PelangganController::class, 'dashboard'])->name('dashboard');
    Route::get('/medicines', [PelangganController::class, 'medicines'])->name('medicines');
    Route::get('/medicines/search', [PelangganController::class, 'searchMedicines'])->name('medicines.search');
    Route::get('/medicines/{id}', [PelangganController::class, 'showMedicine'])->name('medicines.show');
    Route::get('/medicines/{id}/purchase', [PelangganController::class, 'purchase'])->name('purchase');
    Route::post('/medicines/{id}/purchase', [PelangganController::class, 'storePurchase'])->name('purchase.store');
    Route::get('/purchase-history', [PelangganController::class, 'purchaseHistory'])->name('purchase-history');
    Route::get('/sales/{id}', [PelangganController::class, 'viewSale'])->name('sales.show');
});

// Home redirect
Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->isApoteker()) {
            return redirect()->route('apoteker.dashboard');
        } else {
            return redirect()->route('pelanggan.dashboard');
        }
    }
    return redirect()->route('login');
});
