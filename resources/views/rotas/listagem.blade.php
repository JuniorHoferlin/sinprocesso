<table class="table table-hover table-bordered" width="100%">
    <thead>
    <tr style="background: #eee;">
        <th>
            Descrição
        </th>
        <th>
            Tipo
        </th>
        @if (!isset($imprimir))
            <th colspan="2" width="1%"></th>
        @endif
    </tr>
    </thead>
    <tbody>
    @forelse($dados as $dado)
        <tr>
            <td>{{ $dado->descricao }}</td>
            <td>{{ $dado->tipo->descricao }}</td>
            @if (!isset($imprimir))
                @can('rotas.alterar')
                    <td>
                        @include('partials.botao_editar', ['url' => route('rotas.alterar', $dado->id)])
                    </td>
                @endcan
                @can('rotas.excluir')
                    <td>
                        @include('partials.botao_excluir', ['url' => route('rotas.excluir', $dado->id)])
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