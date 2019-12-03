<table class="table table-hover table-bordered" width="100%">
    <thead>
    <tr style="background: #eee;">
        <th>Descrição</th>
        <th>Áreas</th>
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
                @can('grupo_acesso.alterar')
                    <td>
                        @include('partials.botao_editar', ['url' => route('grupo_acesso.alterar', $dado->id)])
                    </td>
                @endcan
                @can('grupo_acesso.excluir')
                    <td>
                        @include('partials.botao_excluir', ['url' => route('grupo_acesso.excluir', $dado->id)])
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