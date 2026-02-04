<?php

use App\Models\country;
use Spatie\Sitemap\Sitemap;
use App\Models\universities;
use Spatie\Sitemap\Tags\Url;
use App\Models\countrydetails;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// For Maintenance Landing Page
// Route::get('/', function(){
//     return view('maintenance');
// })->name('home');
//Web Routes
Route::get('/', [HomeController::class , 'index'])->name('home');

Route::get('/about', [HomeController::class , 'about'])->name('about');

Route::get('/blog', [HomeController::class , 'blog'])->name('blog');

Route::get('/faqs', [HomeController::class , 'faqs'])->name('faqs');

Route::get('/contact', [HomeController::class , 'showContactForm'])->name('contact');

Route::post('/contact', [HomeController::class , 'contact'])->name('contact.submit');

Route::get('/study-in-{slug}', [HomeController::class , 'detailsShow'])->name('country-details');

Route::post('/consult' , [HomeController::class , 'consultRequest'])->name('consultation');

Route::get('/university/list/{slug?}', [HomeController::class , 'getUniversities'])->name('university.list');

Route::get('/university/details/{name}/{slug}', [HomeController::class ,'uniDetails'])->name('university.details');

Route::post('/reviews', [HomeController::class, 'store'])->name('reviews.store');

Route::get('/404', function(){
    return view('errors.404');
})->name('error-404');

Route::get('/checkEmails', [HomeController::class , 'checkEmail'])->name('email.check');
Route::get('get-country-programs/{country}', action: [RegisterController::class, 'getCountryPrograms']);
Route::get('/get-departments', [RegisterController::class, 'departments']);
Route::get('/get-universities', [RegisterController::class, 'universities']);
Route::get('/check-student-email', [RegisterController::class , 'checkEmail'])->name('student-email-check');
Route::get('/check-student-cnic', [RegisterController::class , 'checkCNIC'])->name('student-cnic-check');
Route::get('student/form/ajax', [RegisterController::class , 'index'])->name('register');
Route::post('student/register', [RegisterController::class , 'store'])->name('student.register');
Route::get('generate/student/profile/{id}', [PdfController::class , 'downloadPdf']);
Route::get('view/student/profile/{id}', [PdfController::class , 'viewPdf']);
Route::get('download/student/documents/{folder}', [DocumentController::class , 'downloadDocuments']);