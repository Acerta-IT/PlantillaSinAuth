<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClockinController;
Route::get('/', function () {
    return view('welcome');
})->name('dashboard');

Route::get('/users', function () {
    return view('users');
})->name('users');

Route::get('/fichaje', function () {
    return view('users');
})->name('clockin');

Route::get('/control-fichaje', function () {
    return view('users');
})->name('clockin-control');
