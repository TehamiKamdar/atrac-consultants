<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Student\AuthController as StudentAuthController;
use Illuminate\Support\Facades\Route;

//Login Form
Route::get('/hfLprTv8', [AdminAuthController::class , 'showLoginForm'])->name('login.form');
//Logging In
Route::post('/hfLprTv8', [AdminAuthController::class , 'login'])->name('login');
//Logout
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware('auth');

Route::get('/student/login', [StudentAuthController::class , 'showLoginForm'])->name('student.login');
Route::post('/student/login', [StudentAuthController::class, 'login']) ->name('student.login.submit');
Route::post('/student/logout', [StudentAuthController::class, 'logout'])->name('student.logout');