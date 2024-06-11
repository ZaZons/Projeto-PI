<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Cliente::class, 'cliente');
    }

    public function index(Request $request): View {
        $filterByNome = $request->nome ?? '';
        $clientes = Cliente::query();

        if ($filterByNome !== '') {
            $userIds = User::where('name', 'like', "%$filterByNome%")->pluck('id');
            $clientes->whereIntegerInRaw('id', $userIds);
        }

        $clientes = $clientes->paginate(10);
        return view('clientes.index', compact('clientes', 'filterByNome'));
    }

    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente): View
    {
        $this->authorize('edit', $cliente);
        return view('clientes.edit', compact('cliente'));
    }

    public function update(ClienteRequest $request, Cliente $cliente): RedirectResponse
    {
        $formData = $request->validated();
        $cliente = DB::transaction(function () use ($formData, $cliente, $request) {
            $cliente->nif = $formData['nif'];
            $cliente->ref_pagamento = $formData['refPagamento'];
            $cliente->tipo_pagamento = $formData['tipoPagamento'];
            $cliente->save();
            $user = $cliente->user;
            $user->name = $formData['name'];
            $user->email = $formData['email'];
            $user->save();
            if ($request->hasFile('file_foto')) {
                if ($user->foto_url) {
                    Storage::delete('public/fotos/' . $user->foto_url);
                }

                $path = $request->file_foto->store('public/fotos');
                $user->foto_url = basename($path);
                $user->save();
            }
            return $cliente;
        });

        return redirect()->route('clientes.show', ['cliente' => $cliente])
            ->with('alert-msg', "O seu perfil foi atualizado com sucesso!")
            ->with('alert-type', 'success');
    }

    public function destroy(Cliente $cliente): RedirectResponse
    {
        try {
            $user = $cliente->user;
                DB::transaction(function () use ($cliente, $user) {
                    $cliente->delete();
                    $user->delete();
                    if ($user->foto_url) {
                        Storage::delete('public/fotos/' . $user->foto_url);
                    }
                });

                return redirect()->route('home')
                    ->with('alert-msg', 'Conta apagada com sucesso')
                    ->with('alert-type', 'success');
        } catch (\Exception $error) {
            $htmlMessage = "Não foi possível apagar a sua conta porque ocorreu um erro! $error";
            $alertType = 'danger';

            return redirect()->route('clientes.show', ['cliente' => $cliente])
                ->with('alert-msg', $htmlMessage)
                ->with('alert-type', $alertType);
        }
    }

    public function destroy_foto(Cliente $cliente): RedirectResponse {
        if ($cliente->user->foto_url) {
            Storage::delete('public/fotos/' . $cliente->user->foto_url);
            $cliente->user->foto_url = null;
            $cliente->user->save();
        }

        return redirect()->route('clientes.edit', ['cliente' => $cliente])
            ->with('alert-msg', 'Foto removida!')
            ->with('alert-type', 'success');
    }

    public function bloquear(Cliente $cliente): RedirectResponse {
        $this->authorize('edit', $cliente);
        $user = $cliente->user;
        $user->bloqueado = !$user->bloqueado;
        $user->save();

        return redirect()->back()
            ->with('alert-msg', "Cliente atualizado com sucesso!")
            ->with('alert-type', 'success');
    }

    public static function updatePagamento(string $tipo, string $ref, int $id): void {
        $cliente = Cliente::query()->where('id', $id);

        $cliente->tipo_pagamento = $tipo;
        $cliente->ref_pagamento = $ref;
    }
}
