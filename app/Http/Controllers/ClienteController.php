<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlunoRequest;
use App\Http\Requests\ClienteRequest;
use App\Models\Aluno;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ClienteController extends Controller
{
    public function index(Request $request): View {
//        $filterByTipo = $request->tipo ?? '';
        $filterByNome = $request->nome ?? '';
        $clientes = Cliente::query();

//        if ($filterByTipo !== '') {
//            $clientes->where('tipo', $filterByTipo);
//        }
//        if ($filterByNome !== '') {
//            $userIds = User::where('name', 'like', "%$filterByNome%")->pluck('id');
//            $clientes->whereIntegerInRaw('id', $userIds);
//        }

        $clientes = $clientes->paginate(10);
        return view('clientes.index', compact('clientes', ));
    }

    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente): View
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function store(Request $request) {
        $formData = $request->validated();
        $cliente = DB::transaction(function () use ($formData, $request) {
            $newUser = new User();
            $newUser->name = $formData['name'];
            $newUser->email = $formData['email'];
            $newUser->password = Hash::make($formData['password']);
            $newUser->tipo = 'C';
            $newUser->save();
            $newCliente = new Cliente();
            $newCliente->id = $newUser->id;
            $newCliente->save();

            if ($request->hasFile('file_foto')) {
                $path = $request->file_foto->store('public/fotos');
                $newUser->foto_url = basename($path);
                $newUser->save();
            }
            return $newCliente;
        });
        $url = route('clientes.show', ['cliente' => $cliente]);
        $htmlMessage = "Cliente <a href='$url'>#{$cliente->id}</a>
                        <strong>\"{$cliente->user->name}\"</strong> foi criado com sucesso!";
        return redirect()->route('home')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function update(ClienteRequest $request, Cliente $cliente): RedirectResponse
    {
        $formData = $request->validated();
        $cliente = DB::transaction(function () use ($formData, $cliente, $request) {
            $cliente->nif = $formData['nif'];
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
            $htmlMessage = "Não foi possível apagar a sua conta porque ocorreu um erro!";
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
}
