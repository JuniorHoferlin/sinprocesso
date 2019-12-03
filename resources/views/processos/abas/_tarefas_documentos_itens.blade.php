<table class="table table-striped">
    <thead>
    <tr>
        <td>Título</td>
        <td>Usuário</td>
        <td width="250">Data</td>
        <td width="150">Ações</td>
    </tr>
    </thead>
    <tbody>
    @forelse($documentos as $documento)
        <tr>
            <td>
                {{ $documento->titulo }}
            </td>
            <td>
                {{ $documento->usuario->nome }}
            </td>
            <td>
                {{ formatarData($documento->created_at, 'd/m/Y \á\s H\hi') }}
            </td>
            <td>
                <a href="{{ url($documento->anexo) }}" target="_blank" class="btn btn-default btn-xs">
                    Visualizar
                </a>
                @can('tarefas.remover_documento')
                    @if ($tarefa->status == 'PENDENTE' && $tarefa->status_array['acao'] != 'semPermissao')
                        <a href="{{ route('tarefas.remover_documento') }}" data-id="{{ $documento->id }}" class="btn btn-danger btn-xs remover-documento-tarefa">
                            Remover
                        </a>
                    @endif
                @endcan
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="99">Nenhum documento adicionado a esta tarefa.</td>
        </tr>
    @endforelse
    </tbody>
</table>