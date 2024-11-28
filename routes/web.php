<?php

use App\Http\Controllers\Frontend\FollowController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\PostlikeController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/register', [UserController::class, 'register'])->name('register');
Route::get('/', [UserController::class, 'login'])->name('login');
Route::get('forgot-password/email', [UserController::class, 'userMailPage'])->name('user.mail.page');

Route::post('register-save', [UserController::class, 'registerSave'])->name('register.save');
Route::post('login-check', [UserController::class, 'loginCheck'])->name('login.check');
Route::post('check-user-mail', [UserController::class, 'sendMailForForgotPassword'])->name('send.mail.verify');
Route::post('update-password', [UserController::class, 'newPassword'])->name('change.password');
Route::post('logout', [UserController::class, 'logout'])->name('logout');

Route::get('verify/user/{token}', [UserController::class, 'verifyUser']);
Route::get('forgot-password/{token}', [UserController::class, 'forgotPassword']);

Route::middleware(AuthMiddleware::class)->group(function () {
    Route::resource('profile', ProfileController::class);
    Route::resource('posts', PostController::class);
    Route::resource('likes', PostlikeController::class);
    Route::get('search', [SearchController::class, 'searchView'])->name('search.view');
    Route::post('search-user', [SearchController::class, 'searchUser'])->name('search.user');
    Route::get('search/user/{username}', [SearchController::class, 'goToProfile'])->name('goto.profile');
    Route::post('search/follow', [FollowController::class, 'followRequest']);
    Route::get('requests', [FollowController::class, 'followRequests'])->name('follow.requests');
    Route::post('action/request', [FollowController::class, 'actionOfRequest']);
});