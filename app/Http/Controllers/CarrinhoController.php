<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CarrinhoController extends Controller
{

    public function index(): View {
        if (!session()->has('carrinho')) {
            $this->initializeCarrinho();
        }

        $carrinho = session('carrinho');

        return view('cart.index', compact('carrinho'));
    }

    public function show(): View {
        if (!session()->has('carrinho')) {
            $this->initializeCarrinho();
        }

        $carrinho = session('carrinho');

        return view('cart.show', compact('carrinho'));
    }

    public function store($sessao): RedirectResponse
    {
        if (!session()->has('carrinho')) {
        $this->initializeCarrinho();
    }
//        $this->initializeCarrinho();
        session()->push('carrinho', $sessao);

        return back();
    }

    public function pay(): RedirectResponse {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('alert-msg', "Inicie sessão para realizar a compra dos bilhetes")
                ->with('alert-type', 'warning');
        }

        if (Auth::user()->tipo != 'C') {
            return back()
                ->with('alert-msg', "Apenas clientes podem comprar bilhetes")
                ->with('alert-type', 'warning');
        }

        $this->initializeCarrinho();

        return back();
    }

    public function destroy(): RedirectResponse {
        $this->initializeCarrinho();

        return back();
    }

    protected function initializeCarrinho(): void
    {
        session()->put('carrinho', []);
    }
}
