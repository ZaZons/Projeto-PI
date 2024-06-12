<?php

namespace App\Http\Controllers;

use App\Http\Requests\PagamentoRequest;
use App\Models\Sessoes;
use App\Services\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use MongoDB\Driver\Query;
use function PHPUnit\Framework\arrayHasKey;

class CarrinhoController extends Controller
{

    public function index(): View {
        if (!session()->has('carrinho')) {
            $this->clear();
        }

        $carrinho = session('carrinho');

        return view('cart.index', compact('carrinho'));
    }

    public function updateQuantidade(Request $request,Sessoes $sessao) {
        $carrinho = session('carrinho');

        if ($request->quantidade <= 0) {
            unset($carrinho[$sessao->id]);
        } else {
            $carrinho[$sessao->id]->custom = $request->quantidade;
        }

        session(['carrinho' => $carrinho]);

        return back();
    }

    public function add(Sessoes $sessao): RedirectResponse
    {
        if (!session()->has('carrinho')) {
           $this->clear();
        }

        $id = $sessao->id;

        $carrinho = session('carrinho');

        if (array_key_exists($id, $carrinho)) {
            $carrinho[$id]->custom++;
        } else {
            $sessao->custom = 1;
            $carrinho[$id] = $sessao;
        }

        session(['carrinho' => $carrinho]);

        return back();
    }

    public function remove(Sessoes $sessao): RedirectResponse {
        $carrinho = session('carrinho');
        $id = $sessao->id;

        unset($carrinho[$id]);

        session(['carrinho' => $carrinho]);

        return back();
    }

    public function checkout() {
        if (!Auth::check() || Auth::user()->tipo !== 'C') {
            return redirect()->route('login')
                ->with('alert-msg', 'Para comprar tem de iniciar sessão como um cliente')
                ->with('alert-type', 'warning');
        }

        return view('cart.checkout');
    }

    public function pagamento(Request $request): View {
        $metodo = $request->metodo ?? '';

        return view('cart.pagamento', compact('metodo'));
    }

    // TODO: gravar metodo de pagamento
    public function pagar(Request $request): RedirectResponse {
        $metodo = $request->metodo;
        $guardarMetodo = $request->guardarMetodo ?? null;
        $paymentWorking = false;
        $ref = '';

        if ($metodo == 'VISA') {
            $ref = $request->number;
            $paymentWorking = Payment::payWithVisa($ref, $request->cvc);
        } elseif ($metodo == 'PAYPAL') {
            $ref = $request->email;
            $paymentWorking = Payment::payWithPaypal($ref);
        } elseif ($metodo == 'MBWAY') {
            $ref = $request->telemovel;
            $paymentWorking = Payment::payWithMBway($ref);
        }

        if ($paymentWorking) {
            if ($guardarMetodo) {
                ClienteController::updatePagamento($metodo, $ref, Auth::user()->id);
            }
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
