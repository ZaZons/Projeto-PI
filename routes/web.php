<?php

use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FilmesController;
use App\Http\Controllers\FuncionariosController;
use App\Http\Controllers\HomeController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('root');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Auth::routes(['verify' => true]);

Route::resource('clientes', ClienteController::class);
Route::delete('clientes/{cliente}/foto', [ClienteController::class, 'destroy_foto'])->name('clientes.foto.destroy');
Route::put('clientes/{cliente}/bloquear', [ClienteController::class, 'bloquear'])->name('clientes.bloquear');

Route::resource('funcionarios', FuncionariosController::class);
Route::delete('funcionarios/{funcionario}/foto', [FuncionariosController::class, 'destroy_foto'])->name('funcionarios.foto.destroy');

//Route::middleware(['auth', 'cliente'])
Route::get('cart/show', [CarrinhoController::class, 'show'])->name('carrinho.show');
Route::get('cart', [CarrinhoController::class, 'index'])->name('carrinho.index');
Route::post('cart', [CarrinhoController::class, 'store'])->name('carrinho.store');
Route::delete('cart', [CarrinhoController::class, 'destroy'])->name('carrinho.destroy');
Route::get('cart/checkout', [CarrinhoController::class, 'checkout'])->name('carrinho.checkout');
Route::get('cart/pagamento', [CarrinhoController::class, 'pagamento'])->name('carrinho.pagamento');
Route::post('cart/{pagar}/pagar', [CarrinhoController::class, 'pagar'])->name('carrinho.pagar');
Route::get('cart/pago', [CarrinhoController::class, 'pago'])->name('carrinho.pago');

Route::resource('filmes', FilmesController::class);
