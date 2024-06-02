<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\HomeController;
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
Route::get('/home', HomeController::class, 'index')->name('home');

Auth::routes();

Route::resource('clientes', ClienteController::class);
