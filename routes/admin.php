<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BlogsController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CountryDetailsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\OfficeController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\UniversityController;
use App\Http\Controllers\Admin\UserController;

//Admin Routes

Route::middleware(['auth'])->group(function(){
    Route::get('dashboard' , [DashboardController::class , 'index'])->name('admin-home');
    Route::get('/get-states/{country_id}', [DashboardController::class, 'getStates']);
    Route::get('/get-cities/{state_id}', [DashboardController::class, 'getCities']);
    Route::prefix('countries')->group(function(){
        Route::get( '' , [AdminController::class , 'countryIndex'])->name('admin-country-index');
        Route::post( 'insert' , [AdminController::class , 'countryStore'])->name('country-store');
        Route::post( 'update' , [AdminController::class , 'countryUpdate'])->name('country-update');
        Route::post( 'active/{id}' , [AdminController::class , 'countryActive'])->name('country-active');
        Route::post( 'inactive/{id}' , [AdminController::class , 'countryInactive'])->name('country-inactive');
        Route::get('get-countries/{id}', [AdminController::class, 'getCountries']);
        Route::post('/update-country-program', [AdminController::class, 'countryProgramLevelsUpdate'])->name('update.country.program');
    });
    Route::get('program-levels', [AdminController::class, 'countryProgramLevelsPage'])->name('admin-program-levels-index');
    Route::prefix('inquiries')->group(function(){
        Route::get( '' , [AdminController::class , 'consultAllIndex'])->name('admin-inquiries');
        Route::post('update/{id}', [AdminController::class , 'updateStatusOfInquiry'])->name('update-inquiries');
        Route::post('delete', [AdminController::class , 'deleteInquiry'])->name('delete-inquiries');
        Route::post('makeconsultsseen', [AdminController::class , 'makeconsultsseen'])->name('admin-makeconsultsseen');
        // Route::get( 'pending' , [AdminController::class , 'consultPendingIndex'])->name('pending-consults');
        // Route::get( 'approved' , [AdminController::class , 'consultApprovedIndex'])->name('approved-consults');
        // Route::get( 'rejected' , [AdminController::class , 'consultRejectedIndex'])->name('rejected-consults');
        // Route::get( 'details/{id}' , [AdminController::class , 'consultDetails'])->name('admin-consult-details');
        // Route::post( 'approve/{id}' , [AdminController::class , 'consultApprove'])->name('consult.approve');
        // Route::post( 'reject/{id}' , [AdminController::class , 'consultReject'])->name('consult.reject');
        // Route::post( 'schedule/{id}' , [AdminController::class , 'consultSchedule'])->name('consult.schedule');
    });
    Route::prefix('universities')->group(function(){
        Route::get('', [UniversityController::class , 'index'])->name('admin-university-index');
        Route::get('list/{id}', [UniversityController::class , 'list'])->name('admin-university-list');
        Route::get('create/{id}', [UniversityController::class , 'create'])->name('admin-university-create');
        Route::post('store', [UniversityController::class , 'store'])->name('admin-university-store');
        Route::get('edit/{id}', [UniversityController::class , 'edit'])->name('admin-university-edit');
        Route::post('update/{id}', [UniversityController::class , 'update'])->name('admin-university-update');
    });
    Route::prefix('details')->group(function(){
        Route::get('', [CountryDetailsController::class , 'index'])->name('admin-country-details');
        Route::get('/{id}/edit', [CountryDetailsController::class , 'edit'])->name('admin-country-details-edit');
        Route::post('update', [CountryDetailsController::class , 'update'])->name('admin-country-details-update');
        // Route::post( 'active/{id}' , [AdminController::class , 'serviceActive'])->name('details-active');
        // Route::post( 'inactive/{id}' , [AdminController::class , 'serviceInactive'])->name('details-inactive');
    });
    Route::prefix('students')->group(function(){
        Route::get('', [StudentController::class , 'index'])->name('admin-students-index');
        Route::get('search', [StudentController::class , 'search'])->name('admin-students-search');
        Route::get('/{studentId}/countries', [StudentController::class, 'getStudentCountriesandProgramLevel']);
        Route::get('/{studentId}/programs', [StudentController::class, 'getStudentPrograms']);
        Route::get('/{studentId}/universities', [StudentController::class , 'getUniversityByStudent'])->name('admin-students-get-university');
        Route::get('/{studentId}/applications', [StudentController::class , 'getApplications'])->name('admin-students-get-applications');
        Route::get('/application-details/{id}', [StudentController::class, 'editApplication'])->name('students.applications.edit');
        Route::post('/application-details/update', [StudentController::class, 'updateApplication'])->name('students.applications.update');
        Route::delete('/applications/{id}', [StudentController::class, 'deleteApplication'])->name('students.applications.delete');
        Route::get('/{studentId}/credentials', [StudentController::class , 'getCredentials'])->name('admin-students-get-credentials');
        Route::get('/{studentId}/university/{universityId}/programs',  [StudentController::class, 'getUniversityprograms'])->name('students.university.programs');
        Route::post('/emailpass/store', [StudentController::class , 'gmailPassStore'])->name('admin-students-set-emailpass');
        Route::post('/applications/store', [StudentController::class , 'store'])->name('admin-students-set-applications');
        Route::put('/applications/{studentId}/status', [StudentController::class, 'updateStatus'])->name('student-applications.update-status');
        Route::delete('/{studentId}/delete', [StudentController::class , 'destroy'])->name('admin-students-delete-applications');
    });
    Route::get('programs', [AdminController::class , 'activePrograms'])->name('admin-programs');
    Route::get('contacts', [ContactController::class , 'index'])->name('admin-contacts');
    Route::prefix('faqs')->group(function(){
        Route::get('', [FaqController::class , 'index'])->name('admin-faqs');
        Route::get('create', [FaqController::class , 'create'])->name('admin-faqs-create');
        Route::post('store', [FaqController::class , 'store'])->name('admin-faqs-store');
        Route::post('delete/{id}', [FaqController::class , 'destroy'])->name('admin-faqs-delete');
    });
    Route::prefix('blogs')->group(function(){
        Route::get('', [BlogsController::class , "index"])->name('admin-blogs-index');
        Route::get('create', [BlogsController::class , "create"])->name('admin-blogs-create');
        Route::post('store', [BlogsController::class , "store"])->name('admin-blogs-store');
        Route::get('show/{id}', [BlogsController::class , "show"])->name('admin-blogs-show');
        Route::get('edit/{id}', [BlogsController::class , "edit"])->name('admin-blogs-edit');
        Route::post('update/{id}', [BlogsController::class , "update"])->name('admin-blogs-update');
        Route::post('destroy/{id}', [BlogsController::class , "destroy"])->name('admin-blogs-destroy');
    });
    Route::prefix('offices')->group(function(){
        Route::get('', [OfficeController::class , "index"])->name('admin-offices-index');
        // Route::get('create', [OfficeController::class , "create"])->name('admin-offices-create');
        Route::post('store', [OfficeController::class , "store"])->name('admin-offices-store');
        Route::post('status', [OfficeController::class , "status"])->name('admin-offices-status');
        // Route::get('show/{id}', [BlogsController::class , "show"])->name('admin-blogs-show');
        Route::get('edit', [OfficeController::class , "edit"])->name('admin-offices-edit');
        Route::post('update', [OfficeController::class , "update"])->name('admin-offices-update');
        Route::post('destroy', [OfficeController::class , "destroy"])->name('admin-offices-destroy');
    });
    Route::prefix('events')->group(function(){
        Route::get('', [EventController::class , "index"])->name('admin-events-index');
        Route::get('calendar', [EventController::class , "calendar"])->name('admin-calendar-index');
        // Route::get('create', [OfficeController::class , "create"])->name('admin-offices-create');
        // Route::post('store', [OfficeController::class , "store"])->name('admin-offices-store');
        // Route::get('show/{id}', [BlogsController::class , "show"])->name('admin-blogs-show');
        // Route::get('edit', [OfficeController::class , "edit"])->name('admin-offices-edit');
        // Route::post('update', [OfficeController::class , "update"])->name('admin-offices-update');
        // Route::post('destroy', [OfficeController::class , "destroy"])->name('admin-offices-destroy');
    });
    Route::prefix('users')->group(function(){
        Route::get('', [UserController::class , "index"])->name('admin-users-index');
        // Route::get('create', [OfficeController::class , "create"])->name('admin-offices-create');
        // Route::post('store', [OfficeController::class , "store"])->name('admin-offices-store');
        // Route::get('show/{id}', [BlogsController::class , "show"])->name('admin-blogs-show');
        // Route::get('edit', [OfficeController::class , "edit"])->name('admin-offices-edit');
        // Route::post('update', [OfficeController::class , "update"])->name('admin-offices-update');
        // Route::post('destroy', [OfficeController::class , "destroy"])->name('admin-offices-destroy');
    });
});