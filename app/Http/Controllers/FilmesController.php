<?php

namespace App\Http\Controllers;

use App\Models\Bilhete;
use App\Models\Filmes;
use App\Models\Genero;
use App\Models\Lugares;
use App\Models\Sessoes;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FilmesController extends Controller
{
    public function index(Request $request)
    {
        $filmesQuery = Filmes::query();

        // Se um gênero for selecionado, filtre pelos filmes desse gênero
        if ($request->filled('genero')) {
            $filmesQuery->where('genero_code', $request->genero);
        }

        // Filtre também por qualquer pesquisa de texto inserida
        if ($request->filled('search')) {
            $filmesQuery->where('titulo', 'like', '%' . $request->search . '%');
        }

        // Carregue os filmes paginados e também os gêneros para a dropdown
        $filmes = $filmesQuery->paginate(10);

        $generos = Genero::pluck('nome', 'code');

        return view('filmes.index', compact('filmes', 'generos'));
    }

    public function show($id)
    {
        $filme = Filmes::findOrFail($id);
        $now = now()->addMinutes(5);

        $sessoes = Sessoes::where('filme_id', $id)
            ->where(function($query) use ($now) {
                $query->where('data', '>', $now->format('Y-m-d'))
                    ->orWhere(function($query) use ($now) {
                        $query->where('data', '=', $now->format('Y-m-d'))
                            ->where('horario_inicio', '>', $now->format('H:i:s'));
                    });
            })
            ->with('sala')
            ->paginate(10);

        foreach ($sessoes as $sessao) {
            $totalLugares = Lugares::where('sala_id', $sessao->sala_id)->count();
            $lugaresUsados = Bilhete::where('sessao_id', $sessao->id)->where('estado', 'usado')->count();
            $sessao->lugares_disponiveis = $totalLugares - $lugaresUsados;
        }

        return view('filmes.show', compact('filme', 'sessoes'));
    }
}

