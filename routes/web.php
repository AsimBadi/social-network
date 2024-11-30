<?php

use App\Http\Controllers\Frontend\ExploreController;
use App\Http\Controllers\Frontend\FollowController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\PostlikeController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('user/register', [UserController::class, 'register'])->name('register');
Route::get('user', [UserController::class, 'login'])->name('login');
Route::get('user/forgot-password/email', [UserController::class, 'userMailPage'])->name('user.mail.page');

Route::post('user/register/save', [UserController::class, 'registerSave'])->name('register.save');
Route::post('user/login/check', [UserController::class, 'loginCheck'])->name('login.check');
Route::post('user/check/usermail', [UserController::class, 'sendMailForForgotPassword'])->name('send.mail.verify');
Route::post('user/update/password', [UserController::class, 'newPassword'])->name('change.password');
Route::post('user/logout', [UserController::class, 'logout'])->name('logout');

Route::get('user/verify/{token}', [UserController::class, 'verifyUser']);
Route::get('user/forgot/password/{token}', [UserController::class, 'forgotPassword']);

Route::middleware(AuthMiddleware::class)->group(function () {
    // Route::resource('profile', ProfileController::class);
    // Route::resource('posts', PostController::class);
    // Route::resource('likes', PostlikeController::class);
    // Route::get('search', [SearchController::class, 'searchView'])->name('search.view');
    // Route::post('search-user', [SearchController::class, 'searchUser'])->name('search.user');
    // Route::get('search/user/{username}', [SearchController::class, 'goToProfile'])->name('goto.profile');
    // Route::post('search/follow', [FollowController::class, 'followRequest']);
    // Route::get('requests', [FollowController::class, 'followRequests'])->name('follow.requests');
    // Route::post('action/request', [FollowController::class, 'actionOfRequest']);
});

Route::middleware(AuthMiddleware::class)->prefix('user')->group(function () {
    Route::resource('profile', ProfileController::class);
    Route::resource('posts', PostController::class);
    Route::resource('likes', PostlikeController::class);
    Route::get('search', [SearchController::class, 'searchView'])->name('search.view');
    Route::post('search/user', [SearchController::class, 'searchUser'])->name('search.user');
    Route::get('search/{username}', [SearchController::class, 'goToProfile'])->name('goto.profile');
    Route::post('search/follow', [FollowController::class, 'followRequest'])->name('search.follow');
    Route::get('requests', [FollowController::class, 'followRequests'])->name('follow.requests');
    Route::post('action/request', [FollowController::class, 'actionOfRequest'])->name('action.request');
    Route::get('explore', [ExploreController::class, 'explorePosts'])->name('explore.posts');
});