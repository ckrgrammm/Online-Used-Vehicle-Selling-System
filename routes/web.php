<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\FreeGiftController;
use App\Http\Controllers\PaymentController;




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


// Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function(){
//     Route::get('/admin_portal', function () {
//         return view('admin/admin-index');
//     });
// });

Route::get('/', function () {
    return view('user/index');
});


Route::get('/admin_portal', function () {
    return view('admin/admin-index');
});


// Route::get('/customer', [UserController::class, 'index']);

// Route::get('/comment', function () {
//     return view('admin/all-comment');
// });

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
    return view('user/all-product');
});






Route::get('/reviews', [ReviewController::class, 'review_page']);



Route::get('user/reset_password/{token}/{email}', [UserController::class, 'verify_reset_password'])->name('reset_password');
Route::prefix('user')->middleware(['auth'])->group(function () {
    // Only authenticated users can access this route
    Route::get('/edit-profile', [UserController::class, 'edit_profile']);
    Route::post('/submitEditProfileForm/{id}', [UserController::class, 'submitEditProfileForm']);
    Route::get('/sell', function () {
        return view('user/sell');
    });
    Route::get('/changePassword', [UserController::class, 'changePassword']);
    
});



Route::view('/register','user/register');
Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/forget_password', [UserController::class, 'forgetPassword']);
Route::post('/submitResetPasswordForm', [UserController::class, 'submitResetPasswordForm']);
Route::post('/sell', [UserController::class, 'sell']);
Route::resource('products', ProductController::class);
Route::resource('comments', ReviewController::class);
Route::resource('customers', UserController::class);
Route::post('/edit_password/{id}', [UserController::class, 'edit_password']);
Route::get('/deleteUser/{id}', [UserController::class, 'destroyUser']);
Route::get('/deleteReview/{id}', [ReviewController::class, 'destroyReview']);

Route::get('/reviews/{reviewId}/like', [ReviewController::class, 'like']);




Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function(){
    Route::get('/add-product', function () {
        return view('admin/add-product');
    });


});
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.delete');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::get('/product_details/{id}', [ProductController::class, 'details'])->name('products.details');
    Route::get('/cart/{id}', [ProductController::class, 'cart'])->name('products.cart');

    Route::get('/admin/all-product', [ProductController::class, 'admin'])->name('products.admin');
    Route::get('/filter', [ProductController::class, 'filterByMake'])->name('filterByMake');











    Route::resource('payments', PaymentController::class);
    Route::get('/deletePayment/{id}', [PaymentController::class, 'destroyPayment']);
    Route::view('/temp','user/temp');
    Route::get('/payment', [PaymentController::class, 'displayPayment'])->name('payment.display');
    Route::post('/payment', [PaymentController::class, 'createPayment'])->name('payment.create');
    Route::get('/payment-history', [PaymentController::class, 'displayPaymentHistory'])->name('payment.displayHistory');
    
    
    Route::apiResource('freegifts', FreeGiftController::class, ['names' => 'freegifts']);
    Route::get('/freegifts/create/new', [FreeGiftController::class, 'create'])->name('freegifts.create');//to fix create modify to show by using /new
    Route::get('/freegifts/edit/{id}', [FreeGiftController::class, 'edit'])->name('freegifts.edit');
    Route::get('/deleteGift/{id}', [FreeGiftController::class, 'destroyGift']);
    