<?php

use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\CurrencyConverterController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\PaymentController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){
    Route::get('/', [HomeController::class,'index'])->name('home');
    Route::get('/products',[ProductController::class,'index'])->name('products.index');
    Route::get('/products/{product:slug}',[ProductController::class,'show'])->name('products.show');
    Route::resource('/cart',CartController::class);
    Route::get('/checkout',[CheckoutController::class,'create'])->name('checkout.create');
    Route::post('/checkout',[CheckoutController::class,'store'])->name('checkout.store');
    Route::view('auth/user/2fa','front.auth.two-factor-auth')->name('auth.2fa');
    Route::post('currency',[CurrencyConverterController::class,'store'])
        ->name('currency.store');

});

Route::get('auth/{provider}/redirect',[SocialLoginController::class,'redirect'])
    ->name('auth.socialite.redirect');
Route::get('auth/{provider}/callback',[SocialLoginController::class,'callback'])
    ->name('auth.socialite.callback');

Route::get('orders/{order}/pay', [PaymentController::class, 'create'])
    ->name('orders.payments.create');

Route::get('orders/{order}/stripe/payment-intent', [PaymentController::class, 'createStripePaymentIntent'])
    ->name('stripe.paymentIntent.create');

Route::get('orders/{order}/pay/stripe/callback', [PaymentController::class, 'confirm'])
    ->name('stripe.return');

require __DIR__.'/admin.php';
