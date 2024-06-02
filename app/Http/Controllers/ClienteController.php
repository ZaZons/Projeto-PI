<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlunoRequest;
use App\Models\Aluno;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ClienteController extends Controller
{
    public function show(Aluno $aluno): View
    {
        $cursos = Curso::all();
        $aluno->load('disciplinas', 'disciplinas.cursoRef');
        return view('alunos.show', compact('aluno', 'cursos'));
    }

    public function edit(Aluno $aluno): View
    {
        $cursos = Curso::all();
        return view('alunos.edit', compact('aluno', 'cursos'));
    }

    public function update(AlunoRequest $request, Aluno $aluno): RedirectResponse
    {
        $formData = $request->validated();
        $aluno = DB::transaction(function () use ($formData, $aluno, $request) {
            $aluno->curso = $formData['curso'];
            $aluno->numero = $formData['numero'];
            $aluno->save();
            $user = $aluno->user;
            $user->tipo = 'D';
            $user->name = $formData['name'];
            $user->email = $formData['email'];
            $user->admin = $formData['admin'];
            $user->genero = $formData['genero'];
            $user->save();
            if ($request->hasFile('file_foto')) {
                if ($user->url_foto) {
                    Storage::delete('public/fotos/' . $user->url_foto);
                }

                $path = $request->file_foto->store('public/fotos');
                $user->url_foto = basename($path);
                $user->save();
            }
            return $aluno;
        });
        $url = route('alunos.show', ['aluno' => $aluno]);
        $htmlMessage = "Aluno <a href='$url'>#{$aluno->id}</a>
                        <strong>\"{$aluno->user->name}\"</strong> foi alterado com sucesso!";
        return redirect()->route('alunos.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function destroy(Aluno $aluno): RedirectResponse
    {
        try {
            $totalDisciplinas = DB::scalar('select count(*) from alunos_disciplinas where aluno_id = ?', [$aluno->id]);
            $user = $aluno->user;
            if ($totalDisciplinas == 0) {
                DB::transaction(function () use ($aluno, $user) {
                    $aluno->delete();
                    $user->delete();
                    if ($user->url_foto) {
                        Storage::delete('public/fotos/' . $user->url_foto);
                    }
                });
                $htmlMessage = "Aluno #{$aluno->id}
                        <strong>\"{$user->name}\"</strong> foi apagado com sucesso!";
                return redirect()->route('alunos.index')
                    ->with('alert-msg', $htmlMessage)
                    ->with('alert-type', 'success');
            } else {
                $url = route('alunos.show', ['aluno' => $aluno]);
                $alertType = 'warning';
                $disciplinasStr = $totalDisciplinas > 0 ?
                    ($totalDisciplinas == 1 ?
                        "está inscrito a 1 disciplina" :
                        "está inscrito a $totalDisciplinas disciplinas") :
                    "";
                $htmlMessage = "Aluno <a href='$url'>#{$aluno->id}</a>
                    <strong>\"{$user->name}\"</strong>
                    não pode ser apagado porque $disciplinasStr!
                    ";
            }
        } catch (\Exception $error) {
            $url = route('alunos.show', ['aluno' => $aluno]);
            $htmlMessage = "Não foi possível apagar o aluno <a href='$url'>#{$aluno->id}</a>
                        <strong>\"{$user->name}\"</strong> porque ocorreu um erro!";
            $alertType = 'danger';
        }
        return back()
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', $alertType);
    }

}
