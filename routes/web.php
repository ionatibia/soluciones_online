<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ServiceController;

Auth::routes();

Route::get('/', function () {
    return redirect(route('home'));
});
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/home', [ServiceController::class, 'home'])->name('home');
Route::get('/home/services', [ServiceController::class, 'getMyServices'])->name('myServices');
Route::get('/home/create', [ServiceController::class, 'create'])->name('service.create');
Route::post('/home/store', [ServiceController::class, 'store'])->name('service.store');
