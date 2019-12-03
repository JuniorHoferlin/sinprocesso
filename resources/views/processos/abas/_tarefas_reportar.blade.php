<h2 style="margin-bottom: 10px;">Tarefas</h2>
<p>Selecione as tarefas para serem reportadas</p>
<hr style="margin: 5px 0px 10px;">
<table class="table table-bordered table-striped">
    @foreach($tarefas as $t)
        <tr>
            <td width="1" class="text-center">
                <input type="checkbox" class="tarefas-reportar" name="tarefas[]" value="{{ $t->id }}"/>
            </td>
            <td class="text-left">T{{ $t->identificador }} - {{ $t->titulo }}</td>
        </tr>
    @endforeach
</table>