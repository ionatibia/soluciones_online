<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

Auth::routes();

Route::get('/', function () {
    return redirect(route('home'));
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/home/services', [HomeController::class, 'getMyServices'])->name('myServices');
Route::post('/home/services', [HomeController::class, 'createService'])->name('createService');
