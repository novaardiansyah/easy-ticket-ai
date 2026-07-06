<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::middleware('guest')->group(function () {
  Route::prefix('auth')->group(function () {
    Route::get('google', [\App\Http\Controllers\Auth\GoogleLoginController::class, 'redirect'])->name('auth.google.redirect');
    Route::get('google/callback', [\App\Http\Controllers\Auth\GoogleLoginController::class, 'callback'])->name('auth.google.callback');
  });
  Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
  Route::post('login', [LoginController::class, 'login']);
  Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
  Route::post('register', [RegisterController::class, 'sendRegistrationLink']);
  Route::get('register/success', [RegisterController::class, 'showSuccessPage'])->name('register.success');
  Route::get('register/setup', [RegisterController::class, 'showSetupForm'])->name('register.setup');
  Route::post('register/setup', [RegisterController::class, 'setupAccount'])->name('register.setup.submit');
});

Route::middleware('auth')->group(function () {
  Route::get('/', [HomeController::class, 'index'])->name('home');
  Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

