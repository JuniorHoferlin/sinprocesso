<table class="table table-hover table-bordered" width="100%">
    <thead>
    <tr style="background: #eee;">
        <th width="5%">Identificador</th>
        <th>Título</th>
        <th>Descrição</th>
        <th>Tipo</th>
        <th>Adciionado em</th>
        <th width="8%">Prazo (dias)</th>
        <th>Área</th>
        @if (!isset($imprimir))
            <th colspan="2" width="1%"></th>
        @endif
    </tr>
    </thead>
    <tbody>
    @forelse($dados as $dado)
        <tr>
            <td>{{ $dado->identificador }}</td>
            <td>{{ $dado->titulo }}</td>
            <td>{{ $dado->descricao }}</td>
            <td>{{ $dado->tipo }}</td>
            <td>{{ formatarData($dado->created_at) }}</td>
            <td>{{ $dado->prazo_dias }}</td>
            <td>{{ $dado->area->descricao }}</td>
            @if (!isset($imprimir))
                @can('tarefas.alterar')
                    <td>
                        @include('partials.botao_editar', ['url' => route('tarefas.alterar', $dado->id)])
                    </td>
                @endcan
                @can('tarefas.excluir')
                    <td>
                        @include('partials.botao_excluir', ['url' => route('tarefas.excluir', $dado->id)])
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