@section('scripts')
    @parent
    <script src="{{ asset('js/sistema/selectareas.js') }}"></script>
@stop

<div class="form-group">
    <label class="col-sm-2 control-label" for="areas">
        Área
    </label>
    <div class="col-sm-6">
        <select name="id_area" id="areas" class="form-control" data-placeholder="Selecione a área..." data-areas="{{ json_encode($areas) }}">
            <option></option>
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="descricao">
        Descrição
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <input autofocus type="text" name="descricao" id="descricao" class="form-control" value="{{ isset($area) ? $area->descricao : '' }}" placeholder="Descrição" required>
    </div>
</div>

<div class="clearfix"></div>
<div class="text-right">
    <a href="{{ route('areas.index') }}" class="btn btn-default" data-dismiss="modal">Cancelar</a>
    <input type="submit" class="btn btn-primary" value="Salvar">
</div>
<input type="hidden" name="_token" value="{{ csrf_token() }}">