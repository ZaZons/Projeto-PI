<?php

namespace App\Http\Controllers;

use App\Http\Requests\PagamentoRequest;
use App\Services\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

    public function checkout(): View {
//        if (!Auth::check()) {
//            return redirect()->route('login')
//                ->with('alert-msg', "Inicie sessão para realizar a compra dos bilhetes")
//                ->with('alert-type', 'warning');
//        }
//
//        if (Auth::user()->tipo != 'C') {
//            return back()
//                ->with('alert-msg', "Apenas clientes podem comprar bilhetes")
//                ->with('alert-type', 'warning');
//        }

        return view('cart.checkout');
    }

    public function pagamento(Request $request): View {
        $metodo = $request->metodo ?? '';

        return view('cart.pagamento', compact('metodo'));
    }

    public function pagar(Request $request): RedirectResponse {
        $metodo = $request->metodo;
        $paymentWorking = false;

        if ($metodo == 'VISA') {
            $paymentWorking = Payment::payWithVisa($request->number, $request->cvc);
        } elseif ($metodo == 'PAYPAL') {
            $paymentWorking = Payment::payWithPaypal($request->email);
        } elseif ($metodo == 'MBWAY') {
            $paymentWorking = Payment::payWithMBway($request->telemovel);
        }

        if ($paymentWorking) {
            return redirect()->route('carrinho.pago');
        }
        
        return back()
            ->with('alert-msg', 'Pagamento não aceite, verifique os seus dados')
            ->with('alert-type', 'warning');
    }

    public function pago(): View {
        return view('cart.pago');
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
