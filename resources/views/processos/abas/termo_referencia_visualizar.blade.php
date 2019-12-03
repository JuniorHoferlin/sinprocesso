<h2>
    Termo de referência
    @if ($termo->anexo && file_exists(base_path($termo->anexo)))
        <a href="{{ url($dado->anexo) }}" target="_blank" class="btn btn-default pull-right">
            Ver anexo
        </a>
    @endif
</h2>

<hr>

<div class="well">
    <h3>Diretoria</h3>
    <p>{{ $termo->diretoria }}</p>

    <hr>

    <h3>Fonte de recursos</h3>
    <p>{{ $termo->fonte_recurso }}</p>

    <hr>

    <h3>Classificação do orçamento</h3>
    <p>{{ $termo->classificacao_orcamento }}</p>

    <hr>

    <h3>Natureza da despesa</h3>
    <p>{{ $termo->natureza_despesa }}</p>

    <hr>

    <h3>Bloco</h3>
    <p>{{ $termo->bloco }}</p>

    <hr>

    <h3>Componente</h3>
    <p>{{ $termo->componente }}</p>

    <hr>

    <h3>Ação</h3>
    <p>{{ $termo->acao }}</p>

    <hr>

    <h3>Programa PPA</h3>
    <p>{{ $termo->programa_ppa }}</p>

    <hr>

    <h3>Ata de registro do preço</h3>
    <p>{{ $termo->ata_regristro_preco }}</p>
</div>


<br>
<h2>Insumos deste processo</h2>

<hr>

<table class="table table-bordered table-striped table-hover">
    <tr>
        <th>Código</th>
        <th>Insumo</th>
        <th>Especificação</th>
        <th>Unidade</th>
        <th>Quantidade</th>
    </tr>

    @foreach ($insumos as $i)
        <?php $insumo = $i->insumoTermo->insumo;?>
        <tr>
            <td style="vertical-align: middle;">{{ $insumo->codigo_produto }}</td>
            <td style="vertical-align: middle;">{{ $insumo->produto }}</td>
            <td style="vertical-align: middle;">{{ $insumo->especificacao }}</td>
            <td style="vertical-align: middle;">{{ $insumo->unidade }}</td>
            <td style="vertical-align: middle;">{{ $i->quantidade }}</td>
        </tr>
    @endforeach
</table>