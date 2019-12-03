<table class="table table-striped">
    <thead>
    <tr>
        <td>Descrição</td>
        <td colspan="2">Adicionado em</td>
    </tr>
    </thead>
    <tbody>
    @forelse($observacoes as $observacao)
        <tr>
            <td>{{ $observacao->descricao }}</td>
            <td>{{ formatarData($observacao->created_at, 'd/m/Y \à\s H:i') }}</td>
            @can('tarefas.remover_observacao')
                @if ($tarefa->status == 'PENDENTE' && $tarefa->status_array['acao'] != 'semPermissao')
                    <td width="1">
                        <a href="{{ route('tarefas.remover_observacao') }}" data-id="{{ $observacao->id }}" class="btn btn-danger btn-xs remover-observacao-tarefa">
                            Remover
                        </a>
                    </td>
                    @endcan
                @endif
        </tr>
    @empty
        <tr>
            <td colspan="99">Nenhuma observação adicionada a esta tarefa.</td>
        </tr>
    @endforelse
    </tbody>
</table>