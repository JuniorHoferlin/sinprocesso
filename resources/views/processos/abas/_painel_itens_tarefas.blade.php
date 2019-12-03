@foreach($tarefas as $tarefa)
    <tr>
        <td>
            {{ str_repeat('-', ((2 * $nivel) - 2)) }}
            {{ implode('.', $sequencial) }}
        </td>
        <td>
            {{ $tarefa->dados->tipo != "PADRÃO" ? ( $tarefa->sala_situacao == "S" ? "({$tarefa->dados->tipo} EM SALA DE SITUAÇÃO)" : "({$tarefa->dados->tipo})" ) : "" }} T{{ $tarefa->dados->identificador }} - {{ $tarefa->dados->titulo }}
            <br>
            <small>{{ $tarefa->status_array['status'] }}</small>
        </td>
        <td>
            @if ($tarefa->aberta)
                {{ $tarefa->usuarioAbertura->nome }}
                <br>
                <small>
                    {{ formatarData($tarefa->data_abertura, 'd/m/Y \à\s H\hi') }}
                </small>
            @endif
        </td>
        <td>
            @if ($tarefa->fechada)
                {{ $tarefa->usuarioFechamento->nome }}
                <br>
                <small>
                    {{ formatarData($tarefa->data_finalizado, 'd/m/Y \à\s H\hi') }}
                </small>
            @endif
        </td>
        <td class="text-center">{{ $tarefa->dias_execucao }}</td>
        <td class="text-center">{{ $tarefa->dados->prazo_dias }}</td>
        <td class="text-center">
            <span class="label label-{{ $tarefa->situacao_prazo == 'Atrasada' ? 'danger' : 'primary' }}">{{ $tarefa->situacao_prazo }}</span>
        </td>
    </tr>

    @if (count($tarefa->tarefasFilhas) > 0)
        <?php $sequencial[] = 1;?>
        @include('processos.abas._painel_itens_tarefas', ['tarefas' => $tarefa->tarefasFilhas, 'nivel' => $nivel + 1, 'sequencial' => $sequencial])
    @endif
@endforeach