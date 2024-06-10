<?php

namespace App\Http\Controllers;

use App\Models\Filmes;
use App\Models\Genero;
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
        $generos = Genero::all();

        return view('filmes.index', compact('filmes', 'generos'));
    }

        public function show(Filmes $filme): View{
        return view('filmes.show', compact('filme'));
    }
}

