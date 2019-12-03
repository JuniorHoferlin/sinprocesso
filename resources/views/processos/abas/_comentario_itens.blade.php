<table class="table table-striped">
    <thead>
    <tr>
        <th>Descrição</th>
        <th colspan="2">Adicionado em</th>
    </tr>
    </thead>
    <tbody>
    @foreach($comentarios as $comentario)
        <tr>
            <td>{{ $comentario->descricao }}</td>
            <td>{{ formatarData($comentario->created_at, 'd/m/Y \à\s H:i') }}</td>
            @can('processos.remover_comentario')
                <td width="1">
                    <a href="{{ route('processos.remover_comentario') }}" data-id="{{ $comentario->id }}" class="btn btn-danger btn-xs remover-comentario">
                        Remover
                    </a>
                </td>
            @endcan
        </tr>
    @endforeach
    <tr id="sem-comentarios" class="{{ count($comentarios) ? 'hide' : '' }}">
        <td colspan="99">Nenhum comentário enviado.</td>
    </tr>
    </tbody>
</table>