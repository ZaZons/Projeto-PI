<table class="table">
    <thead class="table-dark">
    <tr>
        <th></th>
        <th>Nome</th>
        <th>Email</th>
        <th class="button-icon-col"></th>
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
            <td class="button-icon-col"><a class="btn btn-secondary"
                                           href="{{ route('clientes.show', ['cliente' => $cliente, 'accessType' => $accessType]) }}">
                    <i class="fas fa-eye"></i></a></td>
            <td class="button-icon-col"><a class="btn btn-dark"
                                           href="{{ route('clientes.edit', ['cliente' => $cliente, 'accessType' => $accessType]) }}">
                    <i class="fas fa-edit"></i></a></td>
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
