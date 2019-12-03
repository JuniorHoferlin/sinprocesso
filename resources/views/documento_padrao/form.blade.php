<div class="form-group">
    <label class="col-sm-2 control-label" for="titulo">
        Título
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <input type="text" autofocus name="titulo" id="titulo" class="form-control" value="{{ isset($documento) ? $documento->titulo : '' }}" placeholder="Titulo" required>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="descricao">
        Descrição
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <input type="text" name="descricao" id="descricao" class="form-control" value="{{ isset($documento) ? $documento->descricao : '' }}" placeholder="Descrição" required>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="data">
        Data
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <input type="text" name="data" id="data" is="date" class="form-control" value="{{ isset($documento) ? formatarData($documento->data) : '' }}" placeholder="Data" required>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="data">
        Anexo
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        @include('partials.botao_anexar_arquivo_simples', ['nome' => 'anexo', 'nomeArquivo' => isset($documento) ? $documento->anexo : '', 'required' => !isset($documento) ? true : false])
    </div>
</div>

<div class="clearfix"></div>
<div class="text-right">
    <a href="{{ route('documento_padrao.index') }}" class="btn btn-default" data-dismiss="modal">Cancelar</a>
    <input type="submit" class="btn btn-primary" value="Salvar">
</div>
<input type="hidden" name="_token" value="{{ csrf_token() }}">