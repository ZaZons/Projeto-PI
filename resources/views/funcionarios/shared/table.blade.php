<table class="table">
    <thead class="table-dark">
    <tr>
        @if ($showFoto)
            <th></th>
        @endif
        <th>Nome</th>
        @if ($showTipo)
            <th>Tipo</th>
        @endif
        @if ($showDetail)
            <th class="button-icon-col"></th>
        @endif
        @if ($showEdit)
            <th class="button-icon-col"></th>
        @endif
        @if ($showDelete)
            <th class="button-icon-col"></th>
        @endif
    </tr>
    </thead>
    <tbody>
    @foreach ($funcionarios as $funcionario)
        <tr>
            @if ($showFoto)
                <td><img src="{{ $funcionario->fullPhotoUrl }}" alt="Avatar" class="bg-dark rounded-circle"
                         width="45"
                         height="45"></td>
            @endif
            <td>{{ $funcionario->name }}</td>
            @if ($showTipo ?? true)
                <td>{{ $funcionario->tipo }}</td>
            @endif
            @if ($showDetail)
                <td class="button-icon-col"><a class="btn btn-secondary"
                                               href="{{ route('funcionarios.show', ['funcionario' => $funcionario]) }}">
                        <i class="fas fa-eye"></i></a></td>
            @endif
            @if ($showEdit)
                <td class="button-icon-col"><a class="btn btn-dark"
                                               href="{{ route('funcionarios.edit', ['funcionario' => $funcionario]) }}">
                        <i class="fas fa-edit"></i></a></td>
            @endif
            @if ($showDelete)
                <td class="button-icon-col">
                    <form method="POST" action="{{ route('funcionarios.destroy', ['funcionario' => $funcionario]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" name="delete" class="btn btn-danger">
                            <i class="fas fa-trash"></i></button>
                    </form>
                </td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
