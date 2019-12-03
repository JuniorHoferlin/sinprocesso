<h2>Informações do processo</h2>

<hr>

<div class="col-xs-4 form-group">
    <label>Status do processo</label>
    <input type="text" disabled class="form-control" value="{{ $processo->status }}">
</div>

<div class="col-xs-4 form-group">
    <label>Número do processo</label>
    <input type="text" disabled class="form-control" value="{{ $processo->codigo }}">
</div>

<div class="col-xs-4 form-group">
    <label>Abertura</label>
    <input type="text" disabled class="form-control" value="{{ formatarData($processo->created_at, 'd/m/Y \à\s H\hi') }}">
</div>

<div class="col-xs-4 form-group">
    <label>Tipo de processo</label>
    <input type="text" disabled class="form-control" value="{{ $tipo->descricao }}">
</div>

<div class="col-xs-4 form-group">
    <label>Modalidade</label>
    <input type="text" disabled class="form-control" value="{{ $processo->modalidade ? $processo->modalidade->descricao  : ''}}">
</div>

<div class="col-xs-12 form-group">
    <label>Requesito do tipo de processo</label>
    <textarea disabled rows="4" class="form-control">{{ $tipo->requesito }}</textarea>
</div>

<div class="col-xs-12 form-group">
    <label>Detalhamento</label>
    <textarea disabled rows="4" class="form-control">{{ $processo->detalhamento }}</textarea>
</div>

<div class="col-xs-12 form-group">
    <label>Descrição</label>
    <textarea disabled rows="4" class="form-control">{{ $processo->descricao }}</textarea>
</div>

<div class="col-xs-12 form-group">
    <label>Número CIPAR</label>
    <input type="text" disabled class="form-control" value="{{ $processo->numero_cipar }}">
</div>

<div class="col-xs-12 form-group">
    <label>Dados objetivos</label>
    <textarea disabled rows="4" class="form-control">{{ $processo->dados_objetivo }}</textarea>
</div>