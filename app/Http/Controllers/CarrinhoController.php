<?php

namespace App\Http\Controllers;

use App\Models\Bilhete;
use App\Models\Recibo;
use App\Models\Sessoes;
use App\Services\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CarrinhoController extends Controller
{

    public function index(): View {
        if (!session()->has('carrinho')) {
            $this->clear();
        }

        $carrinho = session('carrinho');
        $config = ConfiguracaoController::config();

        return view('cart.index', compact('carrinho', 'config'));
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

    public function checkout()
    {
        if (!Auth::check() || Auth::user()->tipo !== 'C') {
            return redirect()->route('login')
                ->with('alert-msg', 'Para comprar tem de iniciar sessão como um cliente')
                ->with('alert-type', 'warning');
        }
        $cliente = Auth::user()->cliente;

        return view('cart.checkout', compact('cliente'));
    }

    public function pagamento(Request $request): View {
        $metodo = $request->metodo ?? '';
        $nif = $request->nif ?? null;

        $cliente = Auth::user()->cliente;
        $cliente->nif = $nif;

        $usarGuardado = false;

        if ($metodo == 'MetodoGuardado') {
            $metodo = $cliente->tipo_pagamento;
            $usarGuardado = true;
        }

        return view('cart.pagamento', compact('metodo', 'cliente', 'usarGuardado'));
    }

    public function pagar(Request $request) {
        $metodo = $request->metodo;
        $guardarMetodo = $request->guardarMetodo ?? '';
        $paymentWorking = false;
        $ref = '';
        $cliente = Auth::user()->cliente;

        if (sizeof(session('carrinho')) <= 0) {
            return redirect()->route('carrinho.index')
                ->with('alert-msg', 'O seu carrinho está vazio.')
                ->with('alert-type', 'warning');
        }

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

        if (!$paymentWorking) {
            return back()
                ->with('alert-msg', 'Pagamento não aceite, verifique os seus dados')
                ->with('alert-type', 'warning');
        }

        if ($guardarMetodo == 'on') {
            ClienteController::updatePagamento($cliente, $metodo, $ref);
        }

        $carrinho = session('carrinho');
        $preco_individual = ConfiguracaoController::config()->preco_bilhete_sem_iva;
        $recibo = DB::transaction(function () use ($carrinho, $cliente, $metodo, $ref, $preco_individual) {
            $iva = ConfiguracaoController::config()->percentagem_iva;
            $preco_total = 0;
            foreach ($carrinho as $bilhete) {
                $preco_total += $preco_individual * $bilhete->custom;
            }

            $newRecibo = new Recibo();
            $newRecibo->cliente_id = $cliente->id;
            $newRecibo->data = today();
            $newRecibo->preco_total_sem_iva = $preco_total;
            $newRecibo->iva = $preco_total * $iva / 100;
            $newRecibo->preco_total_com_iva = $preco_total * (1 + $iva / 100);
            $newRecibo->nif = $cliente->nif;
            $newRecibo->nome_cliente = $cliente->user->name;
            $newRecibo->tipo_pagamento = $metodo;
            $newRecibo->ref_pagamento = $ref;

            $newRecibo->save();
            return $newRecibo;
        });

        foreach ($carrinho as $sessao) {
            for ($i = 0; $i < $sessao->custom; $i++) {
                DB::transaction(function () use ($recibo, $cliente, $sessao, $preco_individual) {
                    $newBilhete = new Bilhete();
                    $newBilhete->recibo_id = $recibo->id;
                    $newBilhete->cliente_id = $cliente->id;
                    $newBilhete->sessao_id = $sessao->id;
                    $newBilhete->lugar_id = 1;
                    $newBilhete->preco_sem_iva = $preco_individual;
                    $newBilhete->estado = 'não usado';

                    $newBilhete->save();
                });
            }
        }

        $this->clear();
        return redirect()->route('carrinho.pago');
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
