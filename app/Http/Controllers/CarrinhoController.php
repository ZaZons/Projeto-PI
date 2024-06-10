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
            $this->clear();
        }

        $carrinho = session('carrinho');

        return view('cart.index', compact('carrinho'));
    }

    public function store(Request $request): RedirectResponse
    {
        if (!session()->has('carrinho')) {
           $this->clear();
        }

        session()->push('carrinho', $request->sessao);

        return back();
    }

    public function checkout(): View {
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
            $this->clear();
            return redirect()->route('carrinho.pago');
        }

        return back()
            ->with('alert-msg', 'Pagamento não aceite, verifique os seus dados')
            ->with('alert-type', 'warning');
    }

    public function pago(): View {
        return view('cart.pago');
    }

    protected function clear(): RedirectResponse
    {
        session()->put('carrinho', []);

        return back();
    }
}
