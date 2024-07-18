<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ServiceController;

Auth::routes();

Route::get('/', function () {
    return redirect(route('home'));
});
Route::get('/services', [ServiceController::class, 'services'])->name('services.index');
Route::get('/services/list', [ServiceController::class, 'getServices'])->name('services.list');
Route::get('/services/detail/{service}', [ServiceController::class, 'show'])->name('service.detail');
Route::get('/home', [ServiceController::class, 'home'])->name('home');
Route::get('/home/services', [ServiceController::class, 'getMyServices'])->name('myServices');
Route::get('/home/create', [ServiceController::class, 'create'])->name('service.create');
Route::post('/home/store', [ServiceController::class, 'store'])->name('service.store');
Route::get('/home/edit/{service}', [ServiceController::class, 'edit'])->name('service.edit');
Route::put('/home/update/{service}', [ServiceController::class, 'update'])->name('service.update');
Route::delete('/home/destroy/{service}', [ServiceController::class, 'destroy'])->name('service.destroy');
Route::get('/messages/{id}', [ServiceController::class, 'messages'])->name('messages');
Route::post('/message', [ServiceController::class, 'message'])->name('message');
