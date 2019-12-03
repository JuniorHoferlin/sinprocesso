<table class="table table-hover table-bordered" width="100%">
    <thead>
    <tr style="background: #eee;">
        <th>Código</th>
        <th>Nome</th>
        <th>Especificação</th>
        <th>Unidade</th>
        @if (!isset($imprimir))
            <th colspan="2" width="1%"></th>
        @endif
    </tr>
    </thead>
    <tbody>
    @forelse($dados as $dado)
        <tr>
            <td>{{ $dado->codigo_produto }}</td>
            <td>{{ $dado->produto }}</td>
            <td>{{ $dado->especificacao }}</td>
            <td>{{ $dado->unidade }}</td>
            @if (!isset($imprimir))
                @can('insumo.alterar')
                    <td>
                        @include('partials.botao_editar', ['url' => route('insumo.alterar', $dado->id)])
                    </td>
                @endcan
                @can('insumo.excluir')
                    <td>
                        @include('partials.botao_excluir', ['url' => route('insumo.excluir', $dado->id)])
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