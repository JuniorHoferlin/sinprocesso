@section('scripts')
    @parent
    <script src="{{ asset('js/sistema/tipo_processo.js') }}"></script>
@stop

<div class="form-group">
    <label class="col-sm-2 control-label" for="descricao">
        Descrição
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <input autofocus type="text" name="descricao" id="descricao" class="form-control" value="{{ isset($tipo) ? $tipo->descricao : '' }}" placeholder="Descrição" is="required">
        <small>Descreva o nome do tipo do processo a ser cadastrado.</small>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="requesito">
        Requisito
    </label>
    <div class="col-sm-6">
        <textarea name="requesito" id="requesito" rows="4" class="form-control">{{ isset($tipo) ? $tipo->requesito : '' }}</textarea>
        <small>Descreva em qual lei está embasado esse tipo de processo.</small>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="grupos">
        Grupos de Acesso
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <select name="grupos[]" id="grupos" required multiple class="form-control">
            <option></option>
            @foreach($gruposAcesso as $grupo)
                <option {{ isset($tipo) && in_array($grupo['id'], $tipo->gruposAcesso->pluck('id')->toArray()) == $grupo['id'] ? 'selected' : '' }} value="{{ $grupo['id'] }}">{{ $grupo['descricao'] }}</option>
            @endforeach
        </select>
        <small>Selecione os grupos de acesso que podem criar processos deste tipo.</small>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="id_formulario">
        Formulário
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <select name="id_formulario" id="id_formulario" class="form-control" is="required" data-placeholder="Selecione o formulário...">
            <option></option>
            @foreach($formularios as $form)
                <option {{ isset($tipo) && $tipo->id_formulario == $form->id ? 'selected' : '' }} value="{{ $form->id }}">{{ $form->titulo }}</option>
            @endforeach
        </select>
        <small>Selecione o formulário para ser preenchido neste tipo de processo.</small>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="tr">
       Requer uma TR?
       <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
       <select name="tr" class="form-control" id="tr" is="required">
           <option value=""></option>
           <option {{ isset($tipo) && $tipo->tr == 'S' ? 'selected' : ''}} value="S">Sim</option>
           <option {{ isset($tipo) && $tipo->tr == 'N' ? 'selected' : ''}} value="N">Não</option>
       </select>
       <small>Selecione se este tipo de processo possúi um termo de referência obrigatório ou não.</small>
    </div>
</div>

<div class="clearfix"></div>
<div class="text-right">
    <a href="{{ route('tipo_processo.index') }}" class="btn btn-default" data-dismiss="modal">Cancelar</a>
    <input type="submit" class="btn btn-primary" value="{{ $botao }}">
</div>
<input type="hidden" name="_token" value="{{ csrf_token() }}">