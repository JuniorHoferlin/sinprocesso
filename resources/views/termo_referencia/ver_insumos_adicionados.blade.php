<h3>{{$insumoTermoReferencia->insumo->produto}}</h3>

<h4>
    <small>adicionados posteriormente por usuários</small>
</h4>
<hr>

<table class="table table-striped table-bordered">
    <tr>
        <th class="text-nowrap">Usuário</th>
        <th class="text-nowrap">Data / Hora</th>
        <th class="text-nowrap">Qtde.</th>
    </tr>

    <?php foreach ($insumoTermoReferencia->insumoTermoReferenciaAdd as $i): ?>
    <tr>
        <td class="text-nowrap">{{$i->usuario->nome}}</td>
        <td class="text-nowrap">{{$i->dataAcontecimento}}</td>
        <td class="text-nowrap">{{$i->quantidade}}</td>
    </tr>
    <?php endforeach; ?>
</table>