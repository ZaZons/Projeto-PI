<?php

use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FilmesController;
use App\Http\Controllers\FuncionariosController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SessoesController;
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

Route::middleware('can:comprar')->group(function() {
    Route::post('carrinho/{sessao}', [CarrinhoController::class, 'add'])->name('carrinho.add');
    Route::get('carrinho/checkout', [CarrinhoController::class, 'checkout'])->name('carrinho.checkout');
    Route::get('carrinho/pagamento', [CarrinhoController::class, 'pagamento'])->name('carrinho.pagamento');
    Route::post('carrinho/pagar', [CarrinhoController::class, 'pagar'])->name('carrinho.pagar');
    Route::get('cart/pago', [CarrinhoController::class, 'pago'])->name('carrinho.pago');

    Route::resource('carrinho', CarrinhoController::class);
    Route::delete('carrinho', [CarrinhoController::class, 'clear'])->name('carrinho.clear');
});


Route::resource('filmes', FilmesController::class);

Route::resource('sessoes', SessoesController::class);
