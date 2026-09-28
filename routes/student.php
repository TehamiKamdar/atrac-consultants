<?php
use App\Http\Controllers\Student\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'student'])->group(function () {

    Route::get('/student/dashboard', [DashboardController::class, 'index'])->name('student.dashboard');

});