<div class="form-group">
    <label class="col-sm-2 control-label" for="produto">
        Nome do insumo
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <input type="text" autofocus name="produto" id="produto" class="form-control" value="{{ isset($insumo) ? $insumo->produto : '' }}" placeholder="Nome do insumo" required>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="codigo_produto">
        Código do insumo
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <input type="text" autofocus name="codigo_produto" id="codigo_produto" class="form-control" value="{{ isset($insumo) ? $insumo->codigo_produto : '' }}" placeholder="Código do insumo" required>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="especificacao">
        Especificação
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <input type="text" autofocus name="especificacao" id="especificacao" class="form-control" value="{{ isset($insumo) ? $insumo->especificacao : '' }}" placeholder="Especificação" required>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="unidade">
        Unidade
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <input type="text" autofocus name="unidade" id="unidade" class="form-control" value="{{ isset($insumo) ? $insumo->unidade : '' }}" placeholder="Unidade" required>
    </div>
</div>

<div class="clearfix"></div>
<div class="text-right">
    <a href="{{ route('insumo.index') }}" class="btn btn-default" data-dismiss="modal">Cancelar</a>
    <input type="submit" class="btn btn-primary" value="Salvar">
</div>
<input type="hidden" name="_token" value="{{ csrf_token() }}">