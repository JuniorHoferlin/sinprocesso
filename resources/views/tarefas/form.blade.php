@section('scripts')
    @parent
    <script src="{{ asset('js/sistema/selectareas.js') }}"></script>
    <script src="{{ asset('js/sistema/carregagrupoacesso.js') }}"></script>
@stop

<div class="form-group">
    <label class="col-sm-2 control-label" for="identificador">
        Identificador
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <input type="text" name="identificador" id="identificador" class="form-control" value="{{ old('identificador', isset($tarefa) ? $tarefa->identificador : '') }}" placeholder="Identificador" is="numeric">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="titulo">
        Título
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <input type="text" name="titulo" id="titulo" class="form-control" value="{{ old('titulo', isset($tarefa) ? $tarefa->titulo : '') }}" placeholder="Titulo" is="required">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="descricao">
        Descrição
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <textarea name="descricao" id="descricao" class="form-control" is="required">{{ old('descricao', isset($tarefa) ? $tarefa->descricao : '') }}</textarea>
        <small>Descreva oque é preciso fazer para que esta tarefa seja concluída.</small>
    </div>
</div>

@if (!isset($tipo))
    <div class="form-group">
        <label class="col-sm-2 control-label" for="tipo">
            Tipo
            <small><i class="fa fa-asterisk"></i></small>
        </label>
        <div class="col-sm-6">
            <select name="tipo" id="tipo" class="form-control" is="required">
                <option></option>
                @foreach($tipos as $tipo)
                    <option {{ old('tipo', isset($tarefa) ? $tarefa->tipo : '') == $tipo ? 'selected' : '' }} value="{{ $tipo }}">{{ $tipo }}</option>
                @endforeach
            </select>
        </div>
    </div>
@endif

<div class="form-group">
    <label class="col-sm-2 control-label" for="areas">
        Área
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <select name="id_area" id="areas" class="form-control carregargrupoacesso" is="required" data-areas="{{ json_encode($areas) }}" data-placeholder="Selecione...">
            <option></option>
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="carregar-grupos">
        Grupo de Acesso
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <select name="id_grupo_acesso_area" id="carregar-grupos" class="form-control" is="required" data-placeholder="Selecione a área...">
            <option></option>
            @if (isset($grupos))
                @foreach($grupos as $grupo)
                    <option {{ old('id_grupo_acesso_area', isset($tarefa) ? $tarefa->id_grupo_acesso_area : '') == $grupo['id'] ? 'selected'  : ''}} value="{{ $grupo['id'] }}">{{ $grupo['descricao'] }}</option>
                @endforeach
            @endif
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="id_formulario">
        Formulário
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <select name="id_formulario" id="id_formulario" class="form-control" data-placeholder="Selecione o formulário...">
            <option></option>
            @foreach($formularios as $form)
                <option {{ old('id_formulario', isset($tarefa) ? $tarefa->id_formulario : '') == $form->id ? 'selected' : '' }} value="{{ $form->id }}">{{ $form->titulo }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="prazo_minutos">
        Prazo
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <input type="text" name="prazo_minutos" id="prazo_minutos" class="form-control" value="{{ old('prazo_minutos', isset($tarefa) ? $tarefa->prazo_dias : '') }}" placeholder="Prazo em dias" is="numeric">
        <small>Estipule um prazo em dias para essa tarefa seja executada.</small>
    </div>
</div>

<div class="clearfix"></div>
<div class="text-right">
    <a href="{{ route('tarefas.index') }}" class="btn btn-default cancelar-adicionar-tarefa">Cancelar</a>
    <button type="submit" class="btn btn-primary">Salvar</button>
</div>
<input type="hidden" name="_token" value="{{ csrf_token() }}">