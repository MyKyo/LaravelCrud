<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndoController;

// Route Utama
Route::get('/', function () {
    return view('welcome');
});

Route::resource('indo', IndoController::class);
Route::get('/indo/{id}/buy', [IndoController::class, 'showBuy'])->name('indo.buy');
Route::post('/indo/{id}/purchase', [IndoController::class, 'processPurchase'])->name('indo.purchase');

// Route mode admin
Route::get('/switch-admin', function() {
    session(['is_admin' => true]);
    return redirect()->route('indo.index')->with('success', 'Mode Admin Aktif');
})->name('switch.admin');

Route::get('/switch-user', function() {
    session()->forget('is_admin');
    return redirect()->route('indo.index')->with('success', 'Mode User Aktif');
})->name('switch.user');
