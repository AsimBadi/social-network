<?php

use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;


Route::get('/', [UserController::class, 'register'])->name('register');
Route::get('login', [UserController::class, 'login'])->name('login');
Route::get('forgot-password/email', [UserController::class, 'userMailPage'])->name('user.mail.page');

Route::post('register-save', [UserController::class, 'registerSave'])->name('register.save');
Route::post('login-check', [UserController::class, 'loginCheck'])->name('login.check');
Route::post('check-user-mail', [UserController::class, 'sendMailForForgotPassword'])->name('send.mail.verify');
Route::post('update-password', [UserController::class, 'newPassword'])->name('change.password');

Route::get('verify/user/{token}', [UserController::class, 'verifyUser']);
Route::get('forgot-password/{token}', [UserController::class, 'forgotPassword']);

Route::middleware(AuthMiddleware::class)->group(function () {
    Route::resource('profile', ProfileController::class);
});