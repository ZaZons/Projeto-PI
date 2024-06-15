<?php

use App\Http\Controllers\BilheteController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EstatisticaController;
use App\Http\Controllers\FilmesController;
use App\Http\Controllers\FuncionariosController;
use App\Http\Controllers\HistoricoController;
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

Route::post('carrinho/pagar', [CarrinhoController::class, 'pagar'])->name('carrinho.pagar');
Route::put('carrinho/add/{sessao}', [CarrinhoController::class, 'add'])->name('carrinho.add');
Route::put('carrinho/remove/{sessao}', [CarrinhoController::class, 'remove'])->name('carrinho.remove');
Route::put('carrinho/update/{sessao}', [CarrinhoController::class, 'updateQuantidade'])->name('carrinho.updateQuantidade');
Route::get('carrinho/checkout', [CarrinhoController::class, 'checkout'])->name('carrinho.checkout');
Route::get('carrinho/sessao/{sessao}/lugares/{lugar}/nBilhetes/{nBilhetes}/quantidade/{quantidade}', [CarrinhoController::class, 'lugares'])->name('carrinho.lugares');

Route::middleware('can:comprar')->group(function() {
    Route::get('carrinho/pagamento', [CarrinhoController::class, 'pagamento'])->name('carrinho.pagamento');
    Route::get('cart/pago', [CarrinhoController::class, 'pago'])->name('carrinho.pago');

});
Route::resource('carrinho', CarrinhoController::class);
Route::delete('carrinho', [CarrinhoController::class, 'clear'])->name('carrinho.clear');

Route::resource('filmes', FilmesController::class);

Route::resource('sessoes', SessoesController::class);

Route::resource('historico', HistoricoController::class);

Route::get('validarBilhetes/validar', [BilheteController::class, 'validar'])->name('bilhetes.validar');
Route::resource('validarBilhetes', BilheteController::class);


Route::put('validarBilhetes/validar/bilhete/{bilhete}', [BilheteController::class, 'update'])->name('bilhetes.update');
Route::resource('estatisticas', EstatisticaController::class);
