<table class="table table-hover table-bordered" width="100%">
    <thead>
    <tr style="background: #eee;">
        <th>TR</th>
        <th>Assunto</th>
        @if (!isset($imprimir))
            <th colspan="3" width="1%"></th>
        @endif
    </tr>
    </thead>
    <tbody>
    @forelse($dados as $dado)
        <tr>
            <td>{{ "n° ".$dado->codigo }}</td>
            <td>{{ $dado->assunto }}</td>
            @if (!isset($imprimir))
                <td>
                    <a href="{{ url($dado->anexo) }}" target="_blank" class="btn btn-xs btn-default" title="Visualizar">
                        <i class="fa fa-external-link"></i>
                        Visualizar
                    </a>
                </td>
                @can('termo_referencia.alterar')
                    <td>
                        @include('partials.botao_editar', ['url' => route('termo_referencia.alterar', $dado->id)])
                    </td>
                @endcan
                @can('termo_referencia.excluir')
                    <td>
                        @include('partials.botao_excluir', ['url' => route('termo_referencia.excluir', $dado->id)])
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