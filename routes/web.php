<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeavesController;
use App\Http\Controllers\SettingsController;

Route::get('/', function () {
    return view('welcome');
})->name('dashboard');

Route::get('/users', function () {
    return view('users');
})->name('users');

Route::get('/fichaje', function () {
    return view('clockin.clockin');
})->name('clockin');

Route::get('/control-fichaje', function () {
    return view('clockin.control');
})->name('clockin-control');

Route::get('/ausencias', [LeavesController::class, 'index'])->name('leaves');
Route::post('/ausencias', [LeavesController::class, 'store'])->name('leaves.store');

Route::get('/ajustes', [SettingsController::class, 'index'])->name('settings');
Route::put('/ajustes', [SettingsController::class, 'update'])->name('settings.update');
