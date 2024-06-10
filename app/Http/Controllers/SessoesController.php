<?php

namespace App\Http\Controllers;

use App\Models\Bilhete;
use App\Models\Filmes;
use App\Models\Lugares;
use App\Models\Sessoes;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SessoesController extends Controller
{
    public function index(Request $request): View
    {
        $filmes = Filmes::all();

        $filterByFilme = $request->filme ?? '';
        $filterBySala = $request->sala ?? '';
        $filterByData = $request->data ?? '';
        $filterByHorario = $request->horario ?? '';

        $sessoesQuery = Sessoes::query();

        if ($filterByFilme !== '') {
            $sessoesQuery->leftJoin('filmes', 'filmes.id', '=', 'sessoes.filme_id')
                ->where('filmes.titulo', 'like', '%' . $filterByFilme . '%');
        }

        if ($filterBySala !== '') {
            $sessoesQuery->where('sala_id', $filterBySala);
        }

        if ($filterByData !== '') {
            $sessoesQuery->where('data', $filterByData);
        }

        if ($filterByHorario !== '') {
            $sessoesQuery->where('horario_inicio', $filterByHorario);
        }

        $sessoes = $sessoesQuery->paginate(10);

        // Calcular os lugares não usados para cada sessão
        foreach ($sessoes as $sessao) {
            $lugares = Lugares::where('sala_id', $sessao->sala_id)->get();
            $sessao->lugares_nao_usados = $lugares->filter(function ($lugar) use ($sessao) {
                $bilheteUsado = Bilhete::where('sessao_id', $sessao->id)
                    ->where('lugar_id', $lugar->id)
                    ->where('estado', 'usado')
                    ->exists();
                return !$bilheteUsado;
            });
        }

        return view('sessoes.index', compact('sessoes', 'filmes', 'filterBySala', 'filterByData', 'filterByHorario', 'filterByFilme'));
    }
}
