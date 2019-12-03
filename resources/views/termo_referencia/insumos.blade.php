<h2 class="text-left">
    <small>Adicionar novos insumos para este termo de referência.</small>
</h2>

<hr/>

<div class="row item form-group" id="itens-adicionar-insumo">
    <div class="col-xs-5">
        <label>Escolha um insumo</label>
        <select id="id_insumo" class="form-control">
            <option value=""></option>
            @foreach ($insumos as $i)
                <option {{  $i->disabled ? "disabled" : "" }} value="{{$i->id}}">{{$i->produto}}</option>
            @endforeach
        </select>
    </div>

    <div class="col-xs-2">
        <label>Quantidade</label>
        <input type="text" id="quantidade" class="form-control" mask="numeric"/>
    </div>

    <div class="col-xs-2">
        <label>Média de consumo</label>
        <input type="text" id="media_consumo" class="form-control" mask="numeric"/>
    </div>

    <div class="col-xs-2">
        <label>Valor</label>
        <input type="text" id="valor" class="form-control" mask="money"/>
    </div>

    <div class="col-xs-1">
        <label>&nbsp;</label> <br>
        <button type="button" id="adicionar-insumo" class="btn btn-success btn-block">
            <i class="fa fa-plus"></i>
        </button>
    </div>
</div>

<hr>

<div class="alert alert-info" id="nenhum-insumo-adicionado">
    <p>Nenhum insumo foi adicionado</p>
</div>

<table class="table table-hover table-bordered hide" id="algum-insumo-adicionado">
    <tr>
        <th>Insumo</th>
        <th width="150">Quantidade</th>
        <th width="170">Média de consumo</th>
        <th width="130">Valor</th>
        <th width="1">&nbsp;</th>
    </tr>

    <tbody id="aqui-adiciona-insumo"></tbody>
</table>