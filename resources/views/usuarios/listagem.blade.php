<table class="table table-hover table-bordered" width="100%">
    <thead>
    <tr style="background: #eee;">
        <th>Nome</th>
        <th>CPF</th>
        <th>Email</th>
        <th>Cidade/UF</th>
        <th>Status</th>
        @if (!isset($imprimir))
            <th colspan="3" width="1%"></th>
        @endif
    </tr>
    </thead>
    <tbody>
    @forelse($dados as $dado)
        <tr>
            <td>{{ $dado->nome }}</td>
            <td>{{ formatarCpf($dado->cpf) }}</td>
            <td>{{ $dado->email }}</td>
            <td>{{ $dado->cidade_uf }}</td>
            <td>{{ $dado->status }}</td>
            @if (!isset($imprimir))
                @can('usuarios.alterar')
                    <td>
                        @if ($dado->status == 'Ativo')
                            <a href="{{ route('usuarios.alterar_status', $dado->id) }}" class="btn btn-xs btn-danger" title="Desativar">
                                <i class="fa fa-ban"></i>
                                Desativar
                            </a>
                        @else
                            <a href="{{ route('usuarios.alterar_status', $dado->id) }}" class="btn btn-xs btn-primary" title="Ativar">
                                <i class="fa fa-check"></i>
                                Ativar
                            </a>
                        @endif
                    </td>
                @endcan
                @can('usuarios.alterar')
                    <td>
                        @include('partials.botao_editar', ['url' => route('usuarios.alterar', $dado->id)])
                    </td>
                @endcan
                @can('usuarios.excluir')
                    <td>
                        @include('partials.botao_excluir', ['url' => route('usuarios.excluir', $dado->id)])
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