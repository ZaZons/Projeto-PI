@php
    $precoTotal = 0;
    $precoTotalSemIva = 0;
    $precoComIva = 0;
@endphp

<table class="table">
    <thead class="table-dark text-light">
    <tr>
        <th>Filme</th>
        <th>Data</th>
        <th>Hora</th>
        <th>Sala</th>
        <th>Lugar</th>
        <th>Preço (s/ IVA)</th>
        <th>Preço (c/ IVA {{$iva}}%)</th>
        <th>Remover</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($bilhetes as $bilhete)
        <tr>
            <td>{{ $bilhete->sessao->filme->titulo }}</td>
            <td>{{ \Carbon\Carbon::parse($bilhete->sessao->data)->format('d/m/Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($bilhete->sessao->horario_inicio)->format('H:i') }}</td>
            <td>{{ $bilhete->sessao->sala->nome }}</td>
            <td>{{ $bilhete->lugar->fila . $bilhete->lugar->posicao }}</td>
            <td>{{ $bilhete->preco_sem_iva }}</td>
            <td>
                @php
                    $precoTotalSemIva += $bilhete->preco_sem_iva;
                    $precoComIva = $bilhete->preco_sem_iva * (1 + $iva / 100);
                    $precoTotal += $precoComIva;
                @endphp
                {{ number_format($precoComIva, 2)  }}
            </td>
            <td>
                <form method="POST" action="{{ route('carrinho.remove') }}">
                    @csrf
                    @method('PUT')
                    <input type="text" name="sessao_id" value="{{ $bilhete->sessao_id }}" class="d-none">
                    <input type="text" name="lugar_id" value="{{ $bilhete->lugar_id }}" class="d-none">
                    <button type="submit" class="btn btn-danger">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<div>
    <div class="d-flex justify-content-end col-10">
        <h4>Preço total</h4>
    </div>
    <div class="d-flex justify-content-end">
        <div class="d-flex justify-content-end"><h5>Bilhetes</h5></div>
        <div class="d-flex justify-content-end ms-5"><h5>{{ number_format($precoTotalSemIva, 2) }}€</h5></div>
    </div>
    <div class="d-flex justify-content-end">
        <div class="d-flex justify-content-end me-2"><h5>IVA</h5></div>
        <div class="d-flex justify-content-end ms-5"><h5>{{ number_format($precoTotalSemIva * $iva / 100, 2) }}€</h5></div>
    </div>
    <div class="d-flex justify-content-end">
        <div class="d-flex justify-content-end"><h5>Preço total</h5></div>
        <div class="d-flex justify-content-end ms-5"><h5>{{ number_format($precoTotal, 2) }}€</h5></div>
    </div>
</div>
