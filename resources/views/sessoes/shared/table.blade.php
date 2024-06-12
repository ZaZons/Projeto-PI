<table class="table">
    <thead class="table-dark">
    <tr>
        <th>Filme</th>
        <th>Data</th>
        <th>Hora</th>
        <th>Sala</th>
        <th>Bilhetes disponíveis</th>
        <th class="button-icon-col"></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($sessoes as $sessao)
        <tr>
            <td>{{ $sessao->filme->titulo }}</td>
            <td>{{ \Carbon\Carbon::parse($sessao->data)->format('d/m/Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($sessao->horario_inicio)->format('H:i') }}</td>
            <td>{{ $sessao->sala->nome }}</td>
            <td>{{ $sessao->lugaresDisponiveis }}</td>
            @if($sessao->lugaresDisponiveis > 0)
                <td>
                    <form method="POST" action="{{ route('carrinho.add', ['sessao' => $sessao]) }}">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success">
                            <i class="fa-solid fa-cart-plus"></i>
                        </button>
                    </form>
                </td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
