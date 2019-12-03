<form name="sequencias">
    <ul class="sortable-list etapas-list connectList agile-list ui-sortable">
        @forelse($tipo->tarefas as $tarefa)
            <li class="row">
                <div class="col-md-1 font-move-section">
                    <i class="fa fa-arrows-alt"></i>
                </div>
                <div class="col-md-11" style="line-height: 28px;">
                    T{{ $tarefa->identificador }} {{ $tarefa->tipo != "PADRÃO" ? "({$tarefa->tipo})" : "" }} -
                    {{ $tarefa->titulo }}
                    <input type="hidden" class="input-order-id" value="1" name="sequencial[{{ $tarefa->id }}]">
                </div>
            </li>
        @empty
            <li>Nenhuma tarefa selecionada.</li>
        @endforelse
    </ul>
    <input type="hidden" name="id_tipo_processo" value="{{ $tipo->id }}">
</form>
