<div class="form-group">
    <label class="col-sm-2 control-label" for="titulo">
        Título
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <input type="text" name="titulo" id="titulo" class="form-control" value="{{ isset($formulario) ? $formulario->titulo : '' }}" placeholder="Título" required>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="descricao">
        Descrição
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <textarea name="descricao" id="descricao" rows="5" class="form-control">{{ isset($formulario) ? $formulario->descricao : '' }}</textarea>
        <small>
            Este campo é utilizado para descrever qual o objetivo deste formulário.
        </small>
    </div>
</div>


<div class="clearfix"></div>
<div class="text-right">
    <a href="{{ route('formularios.index') }}" class="btn btn-default" data-dismiss="modal">Cancelar</a>
    <input type="submit" class="btn btn-primary" value="Salvar">
</div>
<input type="hidden" name="_token" value="{{ csrf_token() }}">