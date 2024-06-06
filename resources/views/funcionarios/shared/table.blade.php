<table class="table">
    <thead class="table-dark">
    <tr>
        <th></th>
        <th>Nome</th>
        <th>Tipo</th>
        <th>Bloqueado</th>
        <th class="button-icon-col"></th>
        <th class="button-icon-col"></th>
        <th class="button-icon-col ml-1"></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($funcionarios as $funcionario)
        <tr>
            <td><img src="{{ $funcionario->fullPhotoUrl }}" alt="Avatar" class="bg-dark rounded-circle"
                     width="45"
                     height="45"></td>
            <td>{{ $funcionario->name }}</td>
            <td>{{ $funcionario->fullTipo }}</td>
            <td>{{ $funcionario->bloqueado ? 'Sim' : 'Não' }}</td>
            <td class="button-icon-col"><a class="btn btn-secondary"
                                           href="{{ route('funcionarios.show', ['funcionario' => $funcionario]) }}">
                    <i class="fas fa-eye"></i></a></td>
            <td class="button-icon-col"><a class="btn btn-dark"
                                           href="{{ route('funcionarios.edit', ['funcionario' => $funcionario]) }}">
                    <i class="fas fa-edit"></i></a></td>
            <td class="button-icon-col">
                <form method="POST" action="{{ route('funcionarios.destroy', ['funcionario' => $funcionario]) }}">
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
