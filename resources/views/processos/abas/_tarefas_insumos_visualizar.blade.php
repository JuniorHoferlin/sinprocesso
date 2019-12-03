<h2>Tarefa T{{ $tarefa->dados->identificador }} - Insumos</h2>
<hr>

<table class="table table-bordered table-striped table-hover">
    <thead>
    <tr>
        <th>Código</th>
        <th>Insumo</th>
        <th>Especificação</th>
        <th>Unidade</th>
        <th colspan="2">Quantidade</th>
    </tr>
    </thead>

    @foreach ($tarefa->insumos as $i)
        <?php $insumo = $i->insumoTermo->insumo;?>
        <tr>
            <td style="vertical-align: middle;">{{ $insumo->codigo_produto }}</td>
            <td style="vertical-align: middle;">{{ $insumo->produto }}</td>
            <td style="vertical-align: middle;">{{ $insumo->especificacao }}</td>
            <td style="vertical-align: middle;">{{ $insumo->unidade }}</td>
            <td style="vertical-align: middle;" width="100">
                {{ $i->pivot->quantidade }}
            </td>
        </tr>
    @endforeach
</table>