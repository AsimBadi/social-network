<?php

use App\Http\Controllers\Backend\ApiAuthController;
use App\Http\Middleware\JwtAuthMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('admin/login', [ApiAuthController::class, 'login']);

Route::middleware(JwtAuthMiddleware::class)->prefix('admin')->group(function () {
    Route::get('user', [ApiAuthController::class, 'getUser']);
    Route::get('logout', [ApiAuthController::class, 'logout']);
    Route::get('/dashboard', [ApiAuthController::class, 'dashboard']);
});