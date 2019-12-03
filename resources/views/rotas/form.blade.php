<div class="form-group">
    <label class="col-sm-2 control-label" for="rota">
        Rota
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <input type="text" autofocus name="rota" id="rota" class="form-control" value="{{ isset($rota) ? $rota->rota : '' }}" placeholder="Nome da rota" required>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label" for="descricao">
        Descrição
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <input type="text" name="descricao" id="descricao" class="form-control" value="{{ isset($rota) ? $rota->descricao : '' }}" placeholder="Descrição" required>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label" for="id_perm_tipo_rota">
        Tipo
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <select class="form-control" name="id_perm_tipo_rota" id="id_perm_tipo_rota" required>
            <option value=""></option>
            @foreach($tipos as $tipo)
                <option {{ isset($rota) && $rota->id_perm_tipo_rota == $tipo->id ? 'selected' : '' }} value="{{ $tipo->id }}">{{ $tipo->descricao }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="clearfix"></div>
<div class="text-right">
    <a href="{{ route('rotas.index') }}" class="btn btn-default" data-dismiss="modal">Cancelar</a>
    <input type="submit" class="btn btn-primary" value="Salvar">
</div>
<input type="hidden" name="_token" value="{{ csrf_token() }}">