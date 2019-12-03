<h2>Tarefa T{{ $tarefa->dados->identificador }} - Insumos</h2>
<hr>

<table class="table table-bordered table-striped table-hover">
    <tr>
        <th width="1"></th>
        <th>Código</th>
        <th>Insumo</th>
        <th>Especificação</th>
        <th>Unidade</th>
        <th colspan="2">Quantidade</th>
    </tr>

    @foreach ($insumosProcesso as $i)
        <?php $insumo = $i->insumoTermo->insumo;?>
        <tr>
            <td style="vertical-align: middle;">
                <label>
                    <input type="checkbox" data-id="{{ $insumo->id }}" name="insumo[{{ $insumo->id }}][id]" value="{{ $insumo->id }}" class="validar-insumo"/>
                </label>
            </td>
            <td style="vertical-align: middle;">{{ $insumo->codigo_produto }}</td>
            <td style="vertical-align: middle;">{{ $insumo->produto }}</td>
            <td style="vertical-align: middle;">{{ $insumo->especificacao }}</td>
            <td style="vertical-align: middle;">{{ $insumo->unidade }}</td>
            <td style="vertical-align: middle;" width="100">
                <input placeholder="Max. {{ $insumo->quantidade }}" type="text" name="insumo[{{ $insumo->id }}][qtd]" data-max="{{ $insumo->quantidade }}" disabled id="{{ 'qtd' . $insumo->id }}" mask="numeric" class="form-control validar-maximo">
            </td>
        </tr>
    @endforeach
</table>