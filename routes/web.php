<?php

use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\CarriageController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\RouteController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\StationController;
use App\Http\Controllers\Admin\TrainController;
use App\Http\Controllers\Auth\GoogleLoginController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::post('/search', [LandingController::class, 'processSearch'])->name('landing.search.process');
Route::get('/search', [LandingController::class, 'search'])->name('landing.search');
Route::get('/get-seats', [LandingController::class, 'getSeats'])->name('landing.get-seats');
Route::get('/bookings/create', [LandingController::class, 'createBooking'])->name('landing.bookings.create');
Route::post('/bookings', [LandingController::class, 'storeBooking'])->name('landing.bookings.store');
Route::get('/bookings/success/{bookingCode}', [LandingController::class, 'bookingSuccess'])->name('landing.bookings.success');

Route::get('privacy-policy', [PageController::class, 'privacy'])->name('privacy');
Route::get('terms-of-service', [PageController::class, 'terms'])->name('terms');

Route::middleware('guest')->group(function () {
  Route::prefix('auth')->group(function () {
    Route::get('google', [GoogleLoginController::class, 'redirect'])->name('auth.google.redirect');
    Route::get('google/callback', [GoogleLoginController::class, 'callback'])->name('auth.google.callback');
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
  Route::get('/home', [HomeController::class, 'redirect'])->name('home');
  Route::post('logout', [LoginController::class, 'logout'])->name('logout');

  Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');
    Route::resource('stations', StationController::class);
    Route::resource('trains', TrainController::class);
    Route::resource('carriages', CarriageController::class);
    Route::resource('routes', RouteController::class);
    Route::resource('schedules', ScheduleController::class);
    Route::get('bookings/get-seats', [BookingController::class, 'getSeats'])->name('bookings.get-seats');
    Route::resource('bookings', BookingController::class)->only(['index', 'show', 'create', 'store', 'update']);
    Route::resource('payments', PaymentController::class)->only(['index', 'show']);
    });
  });

