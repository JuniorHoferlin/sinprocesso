@section('scripts')
    @parent
    <script src="{{ asset('js/sistema/selectareas.js') }}"></script>
@stop

<div class="form-group">
    <label class="col-sm-2 control-label" for="descricao">
        Descrição
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <input type="text" autofocus name="descricao" id="descricao" class="form-control" value="{{ isset($grupo) ? $grupo->descricao : '' }}" placeholder="Descrição" required>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="areas">
        Áreas
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <select name="areas[]" id="areas" multiple class="form-control select2" required data-placeholder="Selecione as áreas..." data-areas="{{ json_encode($areas) }}">
            <option value=""></option>
        </select>
    </div>
</div>

<div class="clearfix"></div>
<div class="text-right">
    <a href="{{ route('grupo_acesso.index') }}" class="btn btn-default" data-dismiss="modal">Cancelar</a>
    <input type="submit" class="btn btn-primary" value="Salvar">
</div>
<input type="hidden" name="_token" value="{{ csrf_token() }}">