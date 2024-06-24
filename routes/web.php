<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/', function () {
    return redirect(route('home'));
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
