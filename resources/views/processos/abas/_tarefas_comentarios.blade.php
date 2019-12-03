<h2>Tarefa T{{ $tarefa->dados->identificador }} - Comentários</h2>
<hr>

@can('tarefas.adicionar_comentario')
    @if ($tarefa->status == 'PENDENTE' && $tarefa->status_array['acao'] != 'semPermissao')
        <div class="well">
            <form action="{{ route('tarefas.adicionar_comentario') }}" method="post" class="validate" name="adicionar-comentario-tarefa">
                <input type="hidden" name="id_tarefa_processo" value="{{ $tarefa->id }}">
                <div class="form-group">
                    <label>Comentário</label>
                    <textarea name="descricao" class="form-control" id="descricao" required rows="3"></textarea>
                </div>
                <p class="text-right">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </p>
            </form>
        </div>
    @endif
@endcan

<div id="comentarios-tarefa">
    @include('processos.abas._tarefas_comentarios_itens', ['tarefa' => $tarefa])
</div>