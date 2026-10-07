<?php
use App\Http\Controllers\Student\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'student'])->group(function () {

    Route::get('/student/dashboard', [DashboardController::class, 'index'])->name('student.dashboard');
    Route::get('/student/documents', [DashboardController::class, 'getDocuments'])->name('student.documents');
    Route::get('/student/applications', [DashboardController::class, 'getApplications'])->name('student.applications');
    Route::get('/student/settings', [DashboardController::class, 'getSettings'])->name('student.settings');

    Route::post('/student/profile/update', [DashboardController::class, 'updateProfile'])->name('student.profile.update');

    Route::delete('/documents/{documentId}/delete', [DashboardController::class, 'deleteDocument'])->name('students-delete-documents');
    Route::post('/documents/{documentId}/edit', [DashboardController::class, 'editDocument'])->name('students-edit-documents');
    Route::get('/documents/{documentId}/view', [DashboardController::class, 'viewDocument'])->name('students-view-document');
    Route::post('/documents/upload', [DashboardController::class, 'uploadDocument'])->name('students-upload-documents');
    Route::post('/student/settings', [DashboardController::class, 'updatePassword'])->name('student.update-password');

});