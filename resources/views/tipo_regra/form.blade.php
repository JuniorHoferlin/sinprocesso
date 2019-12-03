<div class="form-group">
    <label class="col-sm-2 control-label" for="descricao">
        Descrição
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <input type="text" autofocus name="descricao" id="descricao" class="form-control" value="{{ isset($tipo) ? $tipo->descricao : '' }}" placeholder="Descrição" required>
    </div>
</div>
<div class="clearfix"></div>
<div class="text-right">
    <a href="{{ route('tipo_regra.index') }}" class="btn btn-default" data-dismiss="modal">Cancelar</a>
    <input type="submit" class="btn btn-primary" value="Salvar">
</div>
<input type="hidden" name="_token" value="{{ csrf_token() }}">