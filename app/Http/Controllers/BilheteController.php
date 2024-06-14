<?php

namespace App\Http\Controllers;

use App\Models\Bilhete;
use App\Models\Sessoes;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BilheteController extends Controller
{
    public function index(Request $request): View
    {
        $filterById = $request->id ?? '';

        $sessao = Sessoes::find($request->sessao);

        return view('validarBilhetes.index', compact( 'filterById', 'sessao'));
    }

    public function show(Request $request)
    {
        $bilhete = $request->bilhete ?? '';
        return view('validarBilhetes.show', compact('bilhete'));
    }

    public function validar(Request $request)
    {
        $bilhete = $request->search ?? '';
        $sessao = $request->sessao ?? '';

        $bilhete = Bilhete::query()->where('id', $bilhete)->first();
        return view('validarBilhetes.show', compact('bilhete'));

    }

    public function update(Request $request)
    {
        $bilhete = $request->bilhete ?? '';
        $bilhete->estado = 'usado';
        $bilhete->save();
        return redirect()->back()->with('Sucesso', 'Valor atualizado');
    }
}
