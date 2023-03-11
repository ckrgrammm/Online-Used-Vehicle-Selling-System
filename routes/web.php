<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;




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
    return view('user/login');
})->name('login');;

Route::get('logout', function () {
    Session::forget('user');
    return redirect('/login');
});



Route::get('/', function () {
    return view('user/index');
});

Route::get('/admin_portal', function () {
    return view('admin/admin-index');
});

// Route::get('/customer', [UserController::class, 'index']);

Route::get('/comment', function () {
    return view('admin/all-comment');
});

// Route::get('/add-customer', function () {
//     return view('admin/add-customer');
// });

// Route::get('/edit-customer/{id}', [UserController::class, 'find']);

Route::get('/sell', function () {
    return view('user/sell');
});

Route::get('/forget_password', function () {
    return view('user/forgetPassword');
});

Route::get('/all-product', function () {
    return view('user/alls-product');
});

// Route::get('/reviews', function () {
//     return view('user/review');
// });


Route::get('user/reset_password/{token}/{email}', [UserController::class, 'verify_reset_password'])->name('reset_password');
Route::prefix('user')->middleware(['auth'])->group(function () {
    // Only authenticated users can access this route
    Route::get('/edit-profile', [UserController::class, 'edit_profile']);
    Route::post('/submitEditProfileForm/{id}', [UserController::class, 'submitEditProfileForm']);
    Route::get('/sell', function () {
        return view('user/sell');
    });
    
});



Route::view('/register','user/register');
Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/forget_password', [UserController::class, 'forgetPassword']);
Route::post('/submitResetPasswordForm', [UserController::class, 'submitResetPasswordForm']);
Route::post('/sell', [UserController::class, 'sell']);
Route::resource('products', ProductController::class);
Route::resource('reviews', ReviewController::class);
Route::resource('customers', UserController::class);
Route::post('/checkCurrentPassword/{id}', [UserController::class, 'checkCurrentPassword']);
Route::get('/deleteUser/{id}', [UserController::class, 'destroyUser']);

Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
/*if (Auth::user()->isAdmin()) {
    return redirect('/admin/all-product');
}
*/

// Otherwise, redirect them to the user/all-product page
return redirect('/user/alls-product');



/*
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
*/

