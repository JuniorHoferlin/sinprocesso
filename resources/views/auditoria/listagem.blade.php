<table class="table table-hover table-bordered" width="100%">
    <thead>
    <tr style="background: #eee;">
        <th>
            Módulo
        </th>
        <th>
            Ação
        </th>
        <th>
            Usuário
        </th>
        <th>
            Data
        </th>
        <th>
            Ações
        </th>
        @if (!isset($imprimir))
            <th colspan="2" width="1%"></th>
        @endif
    </tr>
    </thead>
    <tbody>
    @forelse($dados as $dado)
        <tr>
            <td>{{ $dado->tipo->descricao }}</td>
            <td>{{ $dado->rota->descricao }}</td>
            <td>{{ $dado->usuario->login }}</td>
            <td>{{ formatarData($dado->created_at, 'd/m/Y \à\s H:i') }}</td>
            <td>{{ $dado->acoes->count() }}</td>
            @if (!isset($imprimir))
                @can('auditoria.visualizar')
                    <td>
                        <a href="{{ route('auditoria.visualizar', $dado->id) }}" class="btn btn-xs btn-default" title="Visualizar">
                            <i class="fa fa-list"></i>
                            Detalhes
                        </a>
                    </td>
                @endcan
            @endif
        </tr>
    @empty
        <tr>
            <td colspan="99">Nenhum registro encontrado.</td>
        </tr>
    @endforelse
    </tbody>
</table>