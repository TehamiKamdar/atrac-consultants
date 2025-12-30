<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

Route::get('/contact', [HomeController::class , 'showContactForm'])->name('contact');

Route::post('/contact', [HomeController::class , 'contact'])->name('contact.submit');

Route::get('/study-in-{name}', [HomeController::class , 'detailsShow'])->name('country-details');

Route::post('/consult' , [HomeController::class , 'consultRequest'])->name('consultation');

Route::get('/university/list/{name?}', [HomeController::class , 'getUniversities'])->name('university.list');

Route::get('/university/details/{name}/{slug}', [HomeController::class ,'uniDetails'])->name('university.details');

Route::get('/404', function(){
    return view('errors.404');
})->name('error-404');

Route::get('/explode',function(){
    $var =
        "Hello Hi How Are You?|I am fine How About You?|Me is good too"
    ;

    $exploded = explode("|", $var);


    return view('test.views', compact('exploded'));
});

Route::get('/checkEmails', [HomeController::class , 'checkEmail'])->name('email.check');