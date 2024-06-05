<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\HomeController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/carrinho', function () {
    return view('carrinho');
});

Route::view('/', 'home')->name('root');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Auth::routes();
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::resource('clientes', ClienteController::class);

