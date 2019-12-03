<div class="form-group">
    <label class="col-sm-2 control-label" for="data">
        Data
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <input type="text" name="data" id="data" class="form-control" value="{{ old('data', isset($feriado) ? formatarData($feriado->data) : '') }}" placeholder="Data do feriado" required is="date">
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label" for="titulo">
        Título
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <input type="text" name="titulo" id="titulo" class="form-control" value="{{ old('titulo', isset($feriado) ? $feriado->titulo : '')  }}" placeholder="Título" required>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label" for="tipo">
        Tipo
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <select name="tipo" id="tipo" class="form-control" data-placeholder="Selecione o tipo...">
            <option></option>
            @foreach($tipos as $tipo)
                <option {{ old('tipo', isset($feriado) ? $feriado->tipo : '') == $tipo ? 'selected' : '' }} value="{{ $tipo }}">{{ $tipo }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="clearfix"></div>
<div class="text-right">
    <a href="{{ route('feriados.index') }}" class="btn btn-default" data-dismiss="modal">Cancelar</a>
    <input type="submit" class="btn btn-primary" value="Salvar">
</div>
<input type="hidden" name="_token" value="{{ csrf_token() }}">