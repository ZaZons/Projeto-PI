<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\exibicao;

Route::get(
    '/exibicao',
    [exibicao::class, 'exibicao']
);

Route::get('/carrinho', function () {
    return view('carrinho');
});

Route::view('/', 'home')->name('root');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

