<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlunoRequest;
use App\Http\Requests\ClienteRequest;
use App\Http\Requests\FuncionarioRequest;
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
    public function index(): View {
        $funcionarios = User::query()->where('tipo', '!=', 'C')->paginate(10);

        return view('funcionarios.index', compact('funcionarios'));
    }

    public function create(): View {
        $funcionario = new User();

        return view('funcionarios.create', compact('funcionario'));
    }

    public function show(User $funcionario): View
    {
        return view('funcionarios.show', compact('funcionario'));
    }

    public function edit(User $funcionario): View
    {
        return view('funcionarios.edit', compact('funcionario'));
    }

    public function store(FuncionarioRequest $request): RedirectResponse
    {
        $formData = $request->validated();
        $funcionario = DB::transaction(function () use ($formData, $request) {
            $newUser = new User();
            $newUser->name = $formData['name'];
            $newUser->email = $formData['email'];
            $newUser->password = Hash::make($formData['password_inicial']);
//            $newUser->tipo = $formData['tipo'];
//            $newUser->bloqueado = $formData['bloqueado'];
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
                        <strong>\"{$funcionario->name}\"</strong> foi criado com sucesso!")
            ->with('alert-type', 'success');
    }

    public function update(FuncionarioRequest $request, User $funcionario): RedirectResponse
    {
        $formData = $request->validated();
        $funcionario = DB::transaction(function () use ($formData, $funcionario, $request) {
            $funcionario->name = $formData['name'];
            $funcionario->email = $formData['email'];
            $funcionario->save();
            if ($request->hasFile('file_foto')) {
                if ($funcionario->foto_url) {
                    Storage::delete('public/fotos/' . $funcionario->foto_url);
                }

                $path = $request->file_foto->store('public/fotos');
                $funcionario->foto_url = basename($path);
                $funcionario->save();
            }
            return $funcionario;
        });

        return redirect()->route('funcionarios.show', ['funcionario' => $funcionario])
            ->with('alert-msg', "O seu perfil foi atualizado com sucesso!")
            ->with('alert-type', 'success');
    }

    public function destroy(User $funcionario): RedirectResponse
    {
        try {
            DB::transaction(function () use ($funcionario) {
                $funcionario->delete();
                if ($funcionario->foto_url) {
                    Storage::delete('public/fotos/' . $funcionario->foto_url);
                }
            });

            return redirect()->route('funcionarios.index')
                ->with('alert-msg', 'Funcionário apagado com sucesso')
                ->with('alert-type', 'success');
        } catch (\Exception $error) {
            $htmlMessage = "Não foi possível apagar o funcionário porque ocorreu um erro!";
            $alertType = 'danger';

            return redirect()->route('funcionarios.show', ['funcionario' => $funcionario])
                ->with('alert-msg', $htmlMessage)
                ->with('alert-type', $alertType);
        }
    }

    public function destroy_foto(User $funcionario): RedirectResponse {

        if ($funcionario->foto_url) {
            Storage::delete('public/fotos/' . $funcionario->foto_url);
            $funcionario->foto_url = null;
            $funcionario->save();
        }

        return redirect()->route('funcionarios.edit', ['funcionario' => $funcionario])
            ->with('alert-msg', 'Foto removida!')
            ->with('alert-type', 'success');
    }
}
