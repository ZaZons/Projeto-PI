<?php

namespace App\Http\Controllers;

use App\Models\Bilhete;
use App\Models\Recibo;
use Illuminate\Http\Request;

class HistoricoController extends Controller
{
    public function index(Request $request){

        $filterByData = request() -> input('data', '');
        $searchTPag = request() -> input('searchTPag', '');
        $searchNif = request() -> input('searchNif', '');

        $recibosQuery = Recibo::query();

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
}
