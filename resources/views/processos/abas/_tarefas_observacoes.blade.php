<h2>Tarefa T{{ $tarefa->dados->identificador }} - Observações</h2>
<hr>

@can('tarefas.adicionar_observacao')
    @if ($tarefa->status == 'PENDENTE' && $tarefa->status_array['acao'] != 'semPermissao')
        <div class="well">
            <form action="{{ route('tarefas.adicionar_observacao') }}" method="post" class="validate" name="adicionar-observacao-tarefa">
                <input type="hidden" name="id_tarefa_processo" value="{{ $tarefa->id }}">
                <div class="form-group">
                    <label>Observação</label>
                    <textarea name="descricao" class="form-control" id="descricao" required rows="3"></textarea>
                </div>
                <p class="text-right">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </p>
            </form>
        </div>
    @endif
@endcan

<div id="observacoes-tarefa">
    @include('processos.abas._tarefas_observacoes_itens', ['tarefa' => $tarefa])
</div>