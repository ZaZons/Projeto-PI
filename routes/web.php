<?php

use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FuncionariosController;
use App\Http\Controllers\HomeController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('root');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Auth::routes();
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::resource('clientes', ClienteController::class);
Route::delete('clientes/{cliente}/foto', [ClienteController::class, 'destroy_foto'])->name('clientes.foto.destroy');

Route::resource('funcionarios', FuncionariosController::class);
Route::delete('funcionarios/{funcionario}/foto', [FuncionariosController::class, 'destroy_foto'])->name('funcionarios.foto.destroy');

Route::get('cart/show', [CarrinhoController::class, 'show'])->name('carrinho.show');
Route::get('cart', [CarrinhoController::class, 'index'])->name('carrinho.index');
Route::post('cart/{sessao}', [CarrinhoController::class, 'store'])->name('carrinho.store');
Route::post('cart', [CarrinhoController::class, 'pay'])->name('carrinho.pay');
Route::delete('cart', [CarrinhoController::class, 'destroy'])->name('carrinho.destroy');
