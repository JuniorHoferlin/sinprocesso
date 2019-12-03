<h2>Tarefas vinculadas a este tipo de processo</h2>
<hr>
<table class="table table-striped table-hover table-bordered dataTable" id="tarefas-escolhidas">
    <thead>
    <tr>
        <th width="30"></th>
        <th width="50">
            <span class="text-nowrap">Identificador</span>
        </th>
        <th width="300">
            <span class="text-nowrap">Titulo da tarefa</span>
        </th>
        <th>
            <span class="text-nowrap">Descrição da tarefa</span>
        </th>
    </tr>
    </thead>
    <tbody>
    @forelse($tarefas as $tarefa)
        <tr style="cursor: pointer;" class="associar-tarefa">
            <td>
                <input type="checkbox" {{ in_array($tarefa->id, $tipo->tarefas->pluck('id')->toArray()) ? 'checked' : '' }} name="tarefas[]" value="{{ $tarefa->id }}">
            </td>
            <td class="text-nowrap">{{ "T".$tarefa->identificador }} {{ $tarefa->tipo != "PADRÃO" ? "({$tarefa->tipo})" : "" }}</td>
            <td>{{ $tarefa->titulo }}</td>
            <td>{{ $tarefa->descricao }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="99">Nenhuma tarefa cadastrada no sistema.</td>
        </tr>
    @endforelse
    </tbody>
</table>