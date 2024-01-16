<?php

use Illuminate\Support\Facades\Route;

/*
 * assign to RouteServiceProvider
 * prefix : merchant
 * name : merchant.
 * */

Route::controller(App\Http\Controllers\Consumer\Auth\LoginController::class)->group(function () {
    Route::get('login', 'showLoginForm')->name('login.show');
    Route::post('login', 'login')->name('login.post');
    Route::post('logout', 'logout')->name('logout')->middleware('auth:consumer');
});

//Route::get('register', [App\Http\Controllers\Merchant\Auth\RegisterController::class, 'showRegisterForm'])->name('register');
//Route::Post('register', [App\Http\Controllers\Merchant\Auth\RegisterController::class, 'register'])->name('register.post');
//
////forget password
//Route::get('forgot-password', [App\Http\Controllers\Merchant\Auth\ForgotPasswordManager::class, 'forgotPassword'])->name('forgot.password');
//Route::post('forgot-password', [App\Http\Controllers\Merchant\Auth\ForgotPasswordManager::class, 'forgotPasswordPost'])->name('forgot.password.post');
//Route::get('reset-password/{token}', [App\Http\Controllers\Merchant\Auth\ForgotPasswordManager::class, 'resetPassword'])->name('reset.password');
//Route::post('reset-password', [App\Http\Controllers\Merchant\Auth\ForgotPasswordManager::class, 'resetPasswordPost'])->name('reset.password.post');


//Route::get('change-password', 'App\Http\Livewire\Merchant\ChangePasswords')->name('change.password')->middleware('auth:merchant');
//
//Route::middleware(['auth:merchant', 'password.expire', 'checkIsActive'])->group(function () {
//    Route::get('/', [App\Http\Controllers\Merchant\HomeController::class, 'index'])->name('home');
//
//});
