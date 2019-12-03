<h2>Processo: #{{ str_pad($processo->id,4,'0',STR_PAD_LEFT)  }}</h2>
<h3>Insumos</h3>

<hr>

<table class="table table-striped">
    <tr>
        <th class="text-nowrap">Insumo</th>
        <th class="text-nowrap">Qtd. Solicitada</th>
        <th class="text-nowrap">Qtd. Comprada</th>
        <th class="text-nowrap">Qtd. Pendente</th>
    </tr>

    @forelse($processo->insumos as $processoInsumoTermoReferencia)
        <tr>
            <td>{{ $processoInsumoTermoReferencia->insumoTermo->insumo->produto  }}</td>
            <td>{{ $processoInsumoTermoReferencia->quantidade  }}</td>
            <td>{{ $processoInsumoTermoReferencia->quantidadeComprada  }}</td>
            <td>{{ $processoInsumoTermoReferencia->quantidadePendente  }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="5">
                Nenhum insumo para este processo
            </td>
        </tr>
    @endforelse
</table>