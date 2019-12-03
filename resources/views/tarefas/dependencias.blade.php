<h2>Abaixo selecione todas as dependências dessa tarefa</h2>
<small class="text-danger">Esta aba é opcional, você pode ignora-la clicando em Detalhes.</small>
<hr>
<table class="table table-striped table-hover table-bordered dataTable" id="dependencias">
    <thead>
    <tr>
        <th width="5%"></th>
        <th width="30%">
            <spam class="text-nowrap">Titulo da tarefa</spam>
        </th>
        <th width="70%">
            <spam class="text-nowrap">Descrição da tarefa</spam>
        </th>
    </tr>
    </thead>
    <tbody>
    @forelse($tarefas as $item)
        <tr style="cursor: pointer;">
            <td>
                <input type="checkbox" name="dependencias[]" value="{{ $item->id }}" {{ isset($tarefa) && in_array($item->id, $tarefa->dependencias->pluck('id')->toArray()) ? 'checked' : '' }}>
                <span class="hide"></span>
            </td>
            <td>{{ $item->titulo }}</td>
            <td>{{ $item->descricao }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="99">Nenhuma tarefa cadastrada.</td>
        </tr>
    @endforelse
    </tbody>
</table>


<div class="clearfix"></div>