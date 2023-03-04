<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


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

// Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function(){

// });

Route::get('/login', function () {
    return view('login');
})->name('login');;

Route::get('logout', function () {
    Session::forget('user');
    return redirect('/login');
});



Route::get('/', function () {
    return view('index');
});

Route::get('/admin', function () {
    return view('/admin-index');
});

Route::get('/forget_password', function () {
    return view('forgetPassword');
});

Route::get('/all-product', function () {
    return view('all-product');
});

Route::get('/reset_password/{token}/{email}', [UserController::class, 'verify_reset_password'])->name('reset_password');
Route::middleware(['auth'])->group(function () {
    // Only authenticated users can access this route
    Route::get('/edit-profile', [UserController::class, 'edit_profile']);
    Route::post('/submitEditProfileForm/{id}', [UserController::class, 'submitEditProfileForm']);
    
});

Route::view('/register','register');
Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/forget_password', [UserController::class, 'forgetPassword']);
Route::post('/submitResetPasswordForm', [UserController::class, 'submitResetPasswordForm']);




