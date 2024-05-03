<?php

use App\Http\Controllers\VoucherController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/vouchers', [VoucherController::class, 'index'])->name('vouchers.index');
Route::get('/vouchers/redeem/{id}', [VoucherController::class, 'redeem'])->name('vouchers.redeem');
Route::get('/vouchers/redeem-lock-for-update/{id}', [VoucherController::class, 'redeemLockForUpdate']);
