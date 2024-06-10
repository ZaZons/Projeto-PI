<?php

namespace App\Http\Controllers;

use App\Models\Bilhete;
use App\Models\Sessoes;
use App\Models\Filmes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SessoesController extends Controller
{
    public function index(Request $request)
    {
        $sessoesQuery = Sessoes::with(['filme', 'sala']);

        // Filtre por datas
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $sessoesQuery->whereBetween('data', [$start_date, $end_date]);
        }

        // Filtre também por qualquer pesquisa de texto inserida
        if ($request->filled('search')) {
            $search = $request->search;
            $sessoesQuery->whereHas('filme', function($query) use ($search) {
                $query->where('titulo', 'like', '%'.$search.'%');
            });
        }

        // Carregue as sessões paginadas
        $sessoes = $sessoesQuery->paginate(10);

        return view('sessoes.index', compact('sessoes'));
    }
}
