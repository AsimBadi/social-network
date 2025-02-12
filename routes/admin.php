<?php

use Illuminate\Support\Facades\Route;

// Route::view('/dashboard', 'backend.layout.dashboard');
Route::get('/admin/{any?}', function () {
    return view('backend.admin');
})->where('any', '.*');