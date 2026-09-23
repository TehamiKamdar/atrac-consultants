<?php

use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;

//Login Form
Route::get('/hfLprTv8', [AuthController::class , 'showLoginForm'])->name('login.form');
//Logging In
Route::post('/hfLprTv8', [AuthController::class , 'login'])->name('login');
//Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware('auth');