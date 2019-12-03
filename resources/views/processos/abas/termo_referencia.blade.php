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
<h2>Insumos disponíveis para este processo</h2>
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

    @foreach ($insumosExistentes as $insumo)
        <tr>
            <td style="vertical-align: middle;">
                <label>
                    <input type="checkbox" data-id="{{ $insumo->id }}" name="insumo[{{ $insumo->id }}][id]" value="{{ $insumo->id }}" class="validar-insumo"/>
                </label>
            </td>
            <td style="vertical-align: middle;">{{ $insumo->insumo->codigo_produto }}</td>
            <td style="vertical-align: middle;">{{ $insumo->insumo->produto }}</td>
            <td style="vertical-align: middle;">{{ $insumo->insumo->especificacao }}</td>
            <td style="vertical-align: middle;">{{ $insumo->insumo->unidade }}</td>
            <td width="1" style="vertical-align: middle;">
                <span class="text-nowrap">Solicitada: {{ $insumo->solicitado }}</span> <br>
                <span class="text-nowrap">Em processo: {{ $insumo->comprado }}</span> <br>
                <span class="text-nowrap"><strong>*Restante: {{ $insumo->restante }}</strong></span>
            </td>
            <td style="vertical-align: middle;" width="100">
                <input placeholder="Max. {{ $insumo->restante }}" type="text" name="insumo[{{ $insumo->id }}][qtd]" data-max="{{ $insumo->restante }}" disabled id="{{ 'qtd' . $insumo->id }}" mask="numeric" class="form-control validar-maximo">
            </td>
        </tr>
    @endforeach
</table>

<p><strong>* Esta é a quantidade máxima desse insumo que você poderá adicionar neste processo.</strong></p>