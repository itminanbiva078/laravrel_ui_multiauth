<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

    Route::prefix(config('basic.adminPrefix'))->name('admin.')->group(function () {

        Route::controller(App\Http\Controllers\Admin\Auth\LoginController::class)->group(function () {
            Route::get('login', 'showLoginForm')->name('login.show');
            Route::post('login', 'login')->name('login.post');
            Route::post('logout', 'logout')->name('logout')->middleware('auth:web');
        });

        Route::middleware(['auth:web'])->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('home');

            //Users route
            Route::get('user', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('user');

            //Settings route
            Route::get('settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings');



        });
});

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
