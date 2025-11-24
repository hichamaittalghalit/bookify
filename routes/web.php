<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PageController;

// Home page - show books list
Route::get('/', [BookController::class, 'index'])->name('books.index');


// Public book routes
//Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{slug}', [BookController::class, 'show'])->name('books.show');

// Payment routes
Route::post('/payment/initiate', [PaymentController::class, 'initiate'])->name('payment.initiate');
Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
Route::get('/payment/thank-you/{num}', [PaymentController::class, 'thankyou'])->name('payment.thankyou');

// Static pages
Route::get('/faq', [PageController::class, 'faq'])->name('pages.faq');
Route::get('/legal-notice', [PageController::class, 'legalNotice'])->name('pages.legal-notice');
Route::get('/terms', [PageController::class, 'terms'])->name('pages.terms');
Route::get('/privacy', [PageController::class, 'privacy'])->name('pages.privacy');

// Language switch
Route::get('/lang/{locale}', [App\Http\Controllers\LanguageController::class, 'switch'])->name('lang.switch');

// Admin routes - Auth (public)
Route::prefix('admin')->name('admin.')->group(function () {
    // Login routes (public)
    Route::get('/login', [App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Admin\AuthController::class, 'login']);
    
    // Password reset routes (public)
    Route::get('/forgot-password', [App\Http\Controllers\Admin\AuthController::class, 'showPasswordResetForm'])->name('password.request');
    Route::post('/forgot-password', [App\Http\Controllers\Admin\AuthController::class, 'sendPasswordResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [App\Http\Controllers\Admin\AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [App\Http\Controllers\Admin\AuthController::class, 'resetPassword'])->name('password.update');
    
    // Protected admin routes
    Route::middleware('admin')->group(function () {
        Route::post('/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        
        // Books CRUD
        Route::resource('books', App\Http\Controllers\Admin\BookController::class);
        
        // Orders
        Route::get('/orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
        
        // Settings
        Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
        
        // PayPal CRUD
        Route::resource('paypals', App\Http\Controllers\Admin\PayPalController::class);
        
        // Profile
        Route::get('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('profile.password.update');
    });
});
