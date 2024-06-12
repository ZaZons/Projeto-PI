<?php

namespace App\Http\Controllers;

use App\Models\Bilhete;
use App\Models\Recibo;
use App\Models\Sala;
use App\Models\Sessoes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoricoController extends Controller
{
    public function index(Request $request){

        $filterByData = request() -> input('data', '');
        $searchTPag = request() -> input('searchTPag', '');
        $searchNif = request() -> input('searchNif', '');

        $user = Auth::user();

        $recibosQuery = Recibo::query()->where('cliente_id', $user->id);

        if (!(empty($filterByData))) {
            $recibosQuery = $recibosQuery->whereDate('data', $filterByData);
        }
        if ($searchTPag !== '') {
            $recibosQuery->where('tipo_pagamento', 'like', '%'.$request->searchTPag.'%');
        }

        if ($searchNif !== '') {
            $recibosQuery->where('nif','like', '%'.$request->searchNif.'%');
        }

        $recibos = $recibosQuery->paginate(10)->appends([
            'data' => $filterByData,
            'searchTPag' => $searchTPag,
            'searchNif' => $searchNif,
        ]);



        return view('historico.index', compact( 'recibos', 'filterByData', 'searchTPag', 'searchNif'));
    }

    public function show($id)
    {
        $recibo = Recibo::findOrFail($id);

        return view('historico.show', compact('recibo'));
    }
}
