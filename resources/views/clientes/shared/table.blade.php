<table class="table">
    <thead class="table-dark">
    <tr>
        <th></th>
        <th>Nome</th>
        <th>Email</th>
        <th>Bloqueado</th>
        <th class="button-icon-col"></th>
        <th class="button-icon-col ml-1"></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($clientes as $cliente)
        <tr>
            <td><img src="{{ $cliente->user->fullPhotoUrl }}" alt="Avatar" class="bg-dark rounded-circle"
                     width="45"
                     height="45"></td>
            <td>{{ $cliente->user->name }}</td>
            <td>{{ $cliente->user->email }}</td>
            <td>{{ $cliente->user->bloqueado ? 'Sim' : 'Não' }}</td>
            <td class="button-icon-col">
                <form method="POST" action="{{ route('clientes.bloquear', ['cliente' => $cliente]) }}">
                    @csrf
                    @method('PUT')

                    <button type="submit" class="btn btn-dark">
                        @if($cliente->user->bloqueado)
                            <i class="fa-solid fa-check"></i>
                        @else
                            <i class="fa-solid fa-ban"></i>
                        @endif
                    </button>
                </form>
            <td class="button-icon-col">
                <form method="POST" action="{{ route('clientes.destroy', ['cliente' => $cliente]) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" name="delete" class="btn btn-danger">
                        <i class="fas fa-trash"></i></button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
