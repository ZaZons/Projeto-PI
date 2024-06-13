@extends('template.layout')

@section('titulo', 'Estatísticas de Vendas')

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Estatísticas</li>
        <li class="breadcrumb-item active">Estatísticas de Vendas</li>
    </ol>
@endsection

@section('main')
    <div class="mb-3">
        <form method="GET" action="{{ route('estatisticas.index') }}">
            <div class="form-group">
                <label for="estatisticasDropdown">Selecione a Estatística</label>
                <select class="form-control" id="estatisticasDropdown" name="selecao" onchange="this.form.submit()">
                    <option value="porValor" {{ $selecao == 'porValor' ? 'selected' : '' }}>Por Valor</option>
                    <option value="porQuantidade" {{ $selecao == 'porQuantidade' ? 'selected' : '' }}>Por Quantidade</option>
                    <option value="vendasPorMes" {{ $selecao == 'vendasPorMes' ? 'selected' : '' }}>Vendas por Mês</option>
                    <option value="vendasPorAno" {{ $selecao == 'vendasPorAno' ? 'selected' : '' }}>Vendas por Ano</option>
                    <option value="vendasPorFilme" {{ $selecao == 'vendasPorFilme' ? 'selected' : '' }}>Vendas por Filme</option>
                    <option value="vendasPorGenero" {{ $selecao == 'vendasPorGenero' ? 'selected' : '' }}>Vendas por Gênero</option>
                    <option value="vendasPorCliente" {{ $selecao == 'vendasPorCliente' ? 'selected' : '' }}>Vendas por Cliente</option>
                </select>
            </div>
        </form>

        <br>

        @if($selecao == 'porValor')
            <h4>Por Valor</h4>
            <table class="table">
                <thead class="table-dark">
                <tr>
                    <th>Total de Vendas</th>
                    <th>Maior Venda</th>
                    <th>Menor Venda</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ $totalVendas }}€</td>
                    <td>{{ $maxVendas }}€</td>
                    <td>{{ $minVendas }}€</td>
                </tr>
                </tbody>
            </table>
        @elseif($selecao == 'porQuantidade')
            <h4>Por Quantidade</h4>
            <table class="table">
                <thead class="table-dark">
                <tr>
                    <th>Total de Bilhetes Vendidos</th>
                    <th>Preço de Bilhete mais Alto</th>
                    <th>Preço Médio de Bilhete</th>
                    <th>Preço de Bilhete mais Baixo</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ $totalBilhetes }}</td>
                    <td>{{ $maxBilhetes }}€</td>
                    <td>{{ $mediaBilhetes }}€</td>
                    <td>{{ $minBilhetes }}€</td>
                </tr>
                </tbody>
            </table>
        @elseif($selecao == 'vendasPorMes')
            <h4>Vendas por Mês</h4>
            <table class="table">
                <thead class="table-dark">
                <tr>
                    <th>Ano</th>
                    <th>Mês</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($vendasPorMes as $venda)
                    <tr>
                        <td>{{ $venda->ano }}</td>
                        <td>{{ $venda->mes }}</td>
                        <td>{{ $venda->total }}€</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @elseif($selecao == 'vendasPorAno')
            <h4>Vendas por Ano</h4>
            <table class="table">
                <thead class="table-dark">
                <tr>
                    <th>Ano</th>
                    <th>Total de Vendas</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($vendasPorAno as $venda)
                    <tr>
                        <td>{{ $venda->ano }}</td>
                        <td>{{ $venda->total }}€</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @elseif($selecao == 'vendasPorFilme')
            <h4>Vendas por Filme</h4>
            <table class="table">
                <thead class="table-dark">
                <tr>
                    <th>Filme</th>
                    <th>Total de Vendas</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($vendasPorFilme as $filme)
                    <tr>
                        <td>{{ $filme->titulo }}</td>
                        <td>{{ number_format($filme->total_vendas, 2, ',', '.') }}€</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @elseif($selecao == 'vendasPorGenero')
            <h4>Vendas por Gênero</h4>
            <table class="table">
                <thead class="table-dark">
                <tr>
                    <th>Gênero</th>
                    <th>Total de Vendas</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($vendasPorGenero as $genero)
                    <tr>
                        <td>{{ $genero->nome }}</td>
                        <td>{{ number_format($genero->total_vendas, 2, ',', '.') }}€</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @elseif($selecao == 'vendasPorCliente')
            <h4>Vendas por Cliente</h4>
            <table class="table">
                <thead class="table-dark">
                <tr>
                    <th>NIF</th>
                    <th>Nome do Cliente</th>
                    <th>Total de Vendas</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($vendasPorCliente as $cliente)
                    <tr>
                        @if($cliente->nif == '')
                            <td>---------</td>
                        @else
                            <td>{{ $cliente->nif }}</td>
                        @endif
                        <td>{{$cliente->name}}</td>
                        <td>{{ number_format($cliente->total, 2, ',', '.') }}€</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
