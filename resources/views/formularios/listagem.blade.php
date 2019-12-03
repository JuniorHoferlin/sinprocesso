<table class="table table-hover table-bordered" width="100%">
    <thead>
    <tr style="background: #eee;">
        <th>Título</th>
        <th>Descrição</th>
        <th>Campos</th>
        @if (!isset($imprimir))
            <th colspan="2" width="1%"></th>
        @endif
    </tr>
    </thead>
    <tbody>
    @forelse($dados as $dado)
        <tr>
            <td>{{ $dado->titulo }}</td>
            <td>{{ $dado->descricao }}</td>
            <td>{{ count($dado->campos) }}</td>
            @if (!isset($imprimir))
                @can('formularios.alterar')
                    <td>
                        @include('partials.botao_editar', ['url' => route('formularios.alterar', $dado->id)])
                    </td>
                @endcan
                @can('formularios.excluir')
                    <td>
                        @include('partials.botao_excluir', ['url' => route('formularios.excluir', $dado->id)])
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