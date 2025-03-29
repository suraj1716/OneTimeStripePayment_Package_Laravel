<?php

use Suraj1716\Onetimestripe\Http\Controllers\ProductController;
use Suraj1716\Onetimestripe\Http\Controllers\CartController;


use Illuminate\Support\Facades\Route;

Route::get('/products', [ProductController::class,'index']);
// Route::post('/checkout', [StripeController::class,'checkout'])->name('checkout');
// Route::get('/success', [StripeController::class, 'success'])->name('checkout.success');
Route::get('/cancel', [ProductController::class,'cancel'])->name('checkout.cancel');



// Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::delete('/cart/remove/{productId}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart/checkout', [CartController::class, 'proceedToCheckout'])->name('cart.checkout');  // Make sure this line exists
    Route::get('/checkout/success', [CartController::class, 'success'])->name('checkout.success');
// });


