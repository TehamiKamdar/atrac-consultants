<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

//Login Form
Route::get('/login', [AuthController::class , 'showLoginForm'])->name('login');
//Logging In
Route::post('/login', [AuthController::class , 'login'])->name('login.submit');
//Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware('auth');