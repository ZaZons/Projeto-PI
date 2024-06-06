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

class FuncionariosController extends Controller
{
    public function index() {
        $funcionarios = User::query()->where('tipo', '!=', 'C')->paginate(10);

        return view('funcionarios.index', compact('funcionarios'));
    }

    public function show(User $funcionario)
    {
        return view('funcionarios.show', compact('funcionario'));
    }

    public function edit(User $funcionario): View
    {
        return view('funcionarios.edit', compact('funcionario'));
    }

    public function store(Request $request) {
        $formData = $request->validated();
        $funcionario = DB::transaction(function () use ($formData, $request) {
            $newUser = new User();
            $newUser->name = $formData['name'];
            $newUser->email = $formData['email'];
            $newUser->password = Hash::make($formData['password']);
            $newUser->tipo = $formData['tipo'];
            $newUser->save();

            if ($request->hasFile('file_foto')) {
                $path = $request->file_foto->store('public/fotos');
                $newUser->foto_url = basename($path);
                $newUser->save();
            }
            return $newUser;
        });
        $url = route('funcionarios.show', ['funcionario' => $funcionario]);

        return redirect()->route('home')
            ->with('alert-msg', "Funcionario <a href='$url'>#{$funcionario->id}</a>
                        <strong>\"{$funcionario->user->name}\"</strong> foi criado com sucesso!")
            ->with('alert-type', 'success');
    }

    public function update(ClienteRequest $request, User $user): RedirectResponse
    {
        $formData = $request->validated();
        $funcionario = DB::transaction(function () use ($formData, $funcionario, $request) {
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
            return $funcionario;
        });

        return redirect()->route('funcionarios.show', ['funcionario' => $funcionario])
            ->with('alert-msg', "O seu perfil foi atualizado com sucesso!")
            ->with('alert-type', 'success');
    }

    public function destroy(Cliente $funcionario): RedirectResponse
    {
        try {
            $user = $funcionario->user;
                DB::transaction(function () use ($funcionario, $user) {
                    $funcionario->delete();
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

            return redirect()->route('funcionarios.show', ['funcionario' => $funcionario])
                ->with('alert-msg', $htmlMessage)
                ->with('alert-type', $alertType);
        }
    }

    public function destroy_foto(Cliente $funcionario): RedirectResponse {
        if ($funcionario->user->foto_url) {
            Storage::delete('public/fotos/' . $funcionario->user->foto_url);
            $funcionario->user->foto_url = null;
            $funcionario->user->save();
        }

        return redirect()->route('funcionarios.edit', ['funcionario' => $funcionario])
            ->with('alert-msg', 'Foto removida!')
            ->with('alert-type', 'success');
    }
}
