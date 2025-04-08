<?php

use App\Http\Controllers\Backend\Api\UserManagementController;
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
    Route::get('/users', [UserManagementController::class, 'users']);
    Route::get('/user/{id}/edit', [UserManagementController::class, 'editUser']);
    Route::post('/user/{id}/update', [UserManagementController::class, 'updateUser']);
    Route::get('/user/{id}/delete', [UserManagementController::class, 'deleteUser']);
    Route::post('/suspend/{id}/user', [UserManagementController::class, 'suspendUser']);
    Route::get('/ban/{id}/user', [UserManagementController::class, 'banUser']);
});