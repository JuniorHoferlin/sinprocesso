<table class="table table-striped">
    <thead>
    <tr>
        <td>Descrição</td>
        <td colspan="2">Adicionado em</td>
    </tr>
    </thead>
    <tbody>
    @forelse($comentarios as $comentario)
        <tr>
            <td>{{ $comentario->descricao }}</td>
            <td>{{ formatarData($comentario->created_at, 'd/m/Y \à\s H:i') }}</td>
            @can('tarefas.remover_comentario')
                @if ($tarefa->status == 'PENDENTE' && $tarefa->status_array['acao'] != 'semPermissao')
                    <td width="1">
                        <a href="{{ route('tarefas.remover_comentario') }}" data-id="{{ $comentario->id }}" class="btn btn-danger btn-xs remover-comentario-tarefa">
                            Remover
                        </a>
                    </td>
                    @endcan
                @endif
        </tr>
    @empty
        <tr>
            <td colspan="99">Nenhum comentário adicionado a esta tarefa.</td>
        </tr>
    @endforelse
    </tbody>
</table>