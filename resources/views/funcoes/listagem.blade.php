<table class="table table-hover table-bordered" width="100%">
    <thead>
    <tr style="background: #eee;">
        <th width="30%">Descrição</th>
        <th width="90%">Áreas</th>
        @if (!isset($imprimir))
            <th colspan="2" width="1%"></th>
        @endif
    </tr>
    </thead>
    <tbody>
    @forelse($dados as $dado)
        <tr>
            <td>{{ $dado->descricao }}</td>
            <td>
                @foreach($dado->areas as $area)
                    <span class="badge">{{ $area->descricao }}</span>
                @endforeach
            </td>
            @if (!isset($imprimir))
                @can('funcoes.alterar')
                    <td>
                        @include('partials.botao_editar', ['url' => route('funcoes.alterar', $dado->id)])
                    </td>
                @endcan
                @can('funcoes.excluir')
                    <td>
                        @include('partials.botao_excluir', ['url' => route('funcoes.excluir', $dado->id)])
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