<div class="form-group">
    <label for="titulo">Titulo
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <input type="text" name="titulo" id="titulo" class="form-control" value="{{ isset($chamado_tecnico) ? $chamado_tecnico->titulo : '' }}" required/>
</div>

<div class="form-group">
    <label for="descricao">Problema
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <textarea name="descricao" id="descricao" rows="4" class="form-control" required>{{ isset($chamado_tecnico) ? $chamado_tecnico->descricao : '' }}</textarea>
</div>

<div class="clearfix"></div>
<div class="text-right">
    <a href="{{ route('suporte.index') }}" class="btn btn-default" data-dismiss="modal">Cancelar</a>
    <input type="submit" class="btn btn-primary" value="Salvar">
</div>

<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="id_usuario" value="{{ auth()->user()->id }}">