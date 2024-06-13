<?php

// Controllers/EstatisticasController.php
namespace App\Http\Controllers;

use App\Models\Bilhete;
use App\Models\Filmes;
use App\Models\Genero;
use App\Models\Recibo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstatisticaController extends Controller
{
    public function index(Request $request)
    {

        $selecao = $request->input('selecao', 'porValor');

        // Estatísticas por valor
        $totalVendas = Recibo::sum('preco_total_com_iva');
        $mediaVendas = Recibo::avg('preco_total_com_iva');
        $maxVendas = Recibo::max('preco_total_com_iva');
        $minVendas = Recibo::min('preco_total_com_iva');

        // Estatísticas por quantidade
        $totalBilhetes = Bilhete::count();
        $mediaBilhetes = Bilhete::avg('preco_sem_iva');
        $maxBilhetes = Bilhete::max('preco_sem_iva');
        $minBilhetes = Bilhete::min('preco_sem_iva');

        // Estatísticas por mês
        $vendasPorMes = Recibo::select(
            DB::raw('YEAR(data) as ano'),
            DB::raw('MONTH(data) as mes'),
            DB::raw('SUM(preco_total_com_iva) as total')
        )->groupBy('ano', 'mes')->get();

        // Estatísticas por ano
        $vendasPorAno = Recibo::select(
            DB::raw('YEAR(data) as ano'),
            DB::raw('SUM(preco_total_com_iva) as total')
        )->groupBy('ano')->get();


// Estatísticas por filme
        $vendasPorFilme = Filmes::with(['sessoes.bilhetes' => function($query) {
            $query->select(DB::raw('SUM(preco_sem_iva) as total'), 'sessao_id')->groupBy('sessao_id');
        }])->get()->map(function($filme) {
            $filme->total_vendas = $filme->sessoes->sum(function($sessao) {
                return $sessao->bilhetes->sum('total');
            });
            return $filme;
        });


// Estatísticas por gênero
        $vendasPorGenero = Genero::with(['filmes.sessoes.bilhetes' => function($query) {
            $query->select(DB::raw('SUM(preco_sem_iva) as total'), 'sessao_id')->groupBy('sessao_id');
        }])->get()->map(function($genero) {
            $genero->total_vendas = $genero->filmes->sum(function($filme) {
                return $filme->sessoes->sum(function($sessao) {
                    return $sessao->bilhetes->sum('total');
                });
            });
            return $genero;
        });

        // Estatísticas por cliente
        $vendasPorCliente = DB::table('recibos')
            ->select('clientes.nif', 'users.name', DB::raw('SUM(preco_total_com_iva) as total'))
            ->join('clientes', 'recibos.cliente_id', '=', 'clientes.id')
            ->join('users', 'clientes.id', '=', 'users.id')
            ->groupBy('clientes.nif', 'users.name')
            ->get();

        return view('estatisticas.index', compact(
            'totalVendas', 'mediaVendas', 'maxVendas', 'minVendas',
            'totalBilhetes', 'mediaBilhetes', 'maxBilhetes', 'minBilhetes',
            'vendasPorMes', 'vendasPorAno', 'vendasPorFilme', 'vendasPorGenero', 'vendasPorCliente', 'selecao'
        ));
    }
}

