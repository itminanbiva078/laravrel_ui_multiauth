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

Auth::routes();

Route::prefix(config('basic.adminPrefix'))->name('admin.')->group(function () {
    Route::controller(App\Http\Controllers\Admin\Auth\LoginController::class)->group(function () {
		Route::get('login', 'showLoginForm')->name('login.show');
		Route::post('login', 'login')->name('login.post');
		Route::post('logout', 'logout')->name('logout')->middleware('auth:web');
	});


    Route::middleware(['guest'])->group(function (){
        Route::view('/login','dashboard.user.login')->name('login');
        Route::view('/register','dashboard.user.register')->name('register');
    });

    Route::middleware(['auth'])->group(function (){
        Route::view('/home','dashboard.user.home')->name('home');
    });

});

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
