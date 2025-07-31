<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

use App\Http\Controllers\StartUpController;
use App\Http\Controllers\ModeController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\CashierController;

//スタート画面
Route::get('/', [StartUpController::class, 'index'])->name('startup');

//選択
Route::get('/mode', [ModeController::class, 'index'])->name('mode');

//管理
Route::get('/management', [ManagementController::class, 'index'])->name('management');

//注文
Route::get('/order', [OrderController::class, 'index'])->name('order');

//キッチン
Route::get('/kitchen', [KitchenController::class, 'index'])->name('kitchen');

//レジ
Route::get('/cashier', [CashierController::class, 'index'])->name('cashier');

