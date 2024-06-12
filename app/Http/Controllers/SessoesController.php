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
        $filterByData = $request->data ?? today();
        $filterByHorario = $request->horario ?? now()->addMinutes(-5);

        $sessoesQuery = Sessoes::query();

        $sessoesQuery->whereDate('data', '>=', $filterByData);
        $sessoesQuery->whereTime('horario_inicio', '>=', $filterByHorario);

        $sessoes = $sessoesQuery->paginate(10);

        return view('sessoes.index', compact('sessoes', 'filterByData', 'filterByHorario'));
    }
}
