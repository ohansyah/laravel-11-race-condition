<?php

use App\Http\Controllers\VoucherController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/vouchers', [VoucherController::class, 'index'])->name('vouchers.index');
Route::get('/vouchers/redeem/{id}', [VoucherController::class, 'redeem'])->name('vouchers.redeem');
Route::get('/vouchers/redeem-lock-for-update/{id}', [VoucherController::class, 'redeemLockForUpdate']);

# example Improving API Performance in Laravel: Guzzle Concurrent Request
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');