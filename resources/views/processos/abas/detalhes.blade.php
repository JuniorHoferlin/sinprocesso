@if (isset($regras) && count($regras) > 0)
    <br>
@endif

<h2>Detalhes do processo</h2>
<hr>

<div class="well">
    <div class="col-xs-12">
        <div class="form-group">
            <label for="modalidade">Modalidade</label>
            <small class="text-info">Selecione a modalidade do seu processo.</small>
            <select name="processo[id_modalidade]" class="form-control" id="id_modalidade">
                <option value=""></option>
                @foreach($modalidades as $modalidade)
                    <option {{ isset($processo) && $processo->id_modalidade == $modalidade->id ? 'selected' : '' }} value="{{ $modalidade->id }}">{{ $modalidade->descricao }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="descricao">Descrição
                <small><i class="fa fa-asterisk"></i></small>
            </label>
            <small class="text-info">Descreva resumidamente seu processo.</small>
            <textarea name="processo[descricao]" class="form-control desativar-com-regra" required id="descricao" rows="3">{{ isset($processo) ? $processo->descricao : '' }}</textarea>

        </div>

        <div class="form-group">
            <label for="detalhamento">Detalhamento
                <small><i class="fa fa-asterisk"></i></small>
            </label>
            <small class="text-info">Descreva detalhadamente seu processo.</small>
            <textarea name="processo[detalhamento]" class="form-control desativar-com-regra" required id="detalhamento" rows="6">{{ isset($processo) ? $processo->detalhamento : '' }}</textarea>
        </div>

        <div class="form-group">
            <label for="numero_cipar">Número CIPAR
                <small><i class="fa fa-asterisk"></i></small>
            </label>
            <input type="text" name="processo[numero_cipar]" required id="numero_cipar" class="form-control desativar-com-regra" value="{{ isset($processo) ? $processo->numero_cipar : '' }}"/>
        </div>

        <div class="form-group">
            <label for="dados_objetivo">Dados objetivos
                <small><i class="fa fa-asterisk"></i></small>
            </label>
            <textarea name="processo[dados_objetivo]" class="form-control desativar-com-regra" required id="dados_objetivo" rows="6">{{ isset($processo) ? $processo->dados_objetivo : '' }}</textarea>
        </div>
    </div>

    <div class="clearfix"></div>
</div>


