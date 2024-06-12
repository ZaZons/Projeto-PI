@php
    $precoSemIva = \App\Http\Controllers\ConfiguracaoController::config()->preco_bilhete_sem_iva;
    $iva = \App\Http\Controllers\ConfiguracaoController::config()->percentagem_iva;
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
        <th>Quantidade</th>
        <th>Preço individual (s/ IVA)</th>
        <th>Preço total (s/ IVA)</th>
        <th>Preço total (c/ IVA {{$iva}}%)</th>
        <th>Remover</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($sessoes as $sessao)
        <tr>
            <td>{{ $sessao->filme->titulo }}</td>
            <td>{{ \Carbon\Carbon::parse($sessao->data)->format('d/m/Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($sessao->horario_inicio)->format('H:i') }}</td>
            <td>{{ $sessao->sala->nome }}</td>
            <td>
                <form method="POST" action="{{ route('carrinho.updateQuantidade', ['sessao' => $sessao]) }}" class="form-floating">
                    @csrf
                    @method('PUT')
                    <input type="number" name="quantidade" value="{{ $sessao->custom }}" min="0">
                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-rotate-right"></i>
                    </button>

                </form>
            </td>
            <td>
                {{ $precoSemIva }}
            </td>
            <td>
                @php
                    $precoTotalSemIva += $precoSemIva * $sessao->custom
                @endphp
                {{ number_format($precoSemIva * $sessao->custom, 2) }} ({{ "$precoSemIva x $sessao->custom" }})
            </td>
            <td>
                @php
                    $precoComIva = $precoSemIva * $sessao->custom * (1 + $iva / 100);
                    $precoTotal += $precoComIva;
                @endphp
                {{ number_format($precoComIva, 2)  }}
            </td>
            <td>
                <form method="POST" action="{{ route('carrinho.remove', ['sessao' => $sessao]) }}">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-success">
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
