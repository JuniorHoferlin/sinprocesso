<h2>Cadastro de regras</h2>
<hr>
<form class="form-horizontal validate" method="post" role="form" action="{{ route('tipo_processo.adicionar_regra') }}" name="adicionar-regras">
    <input type="hidden" name="id_tipo_processo" value="{{ $tipo->id }}">
    <div class="form-group">
        <label class="col-sm-2 control-label" for="titulo">
            Título
            <small><i class="fa fa-asterisk"></i></small>
        </label>
        <div class="col-sm-4">
            <input type="text" name="titulo" id="titulo" class="form-control" is="required">
            <small>Descreva o título dessa regra.</small>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="descricao">
            Descrição
            <small><i class="fa fa-asterisk"></i></small>
        </label>
        <div class="col-sm-8">
            <input type="text" name="descricao" id="descricao" class="form-control" is="required">
            <small>Descreva a descrição dessa regra.</small>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="id_tipo_regra">
            Tipo de regra
            <small><i class="fa fa-asterisk"></i></small>
        </label>
        <div class="col-sm-4">
            <select name="id_tipo_regra" id="id_tipo_regra" is="required" class="form-control">
                <option value=""></option>
                @foreach($tiposRegras as $tRegra)
                    <option value="{{ $tRegra->id }}">{{ $tRegra->descricao }}</option>
                @endforeach
            </select>
            <small>Selecione o tipo de regra.</small>
        </div>
    </div>

    <div class="form-group text-right">
        <div class="col-xs-12">
            <button type="reset" class="btn btn-default">Limpar</button>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </div>
        <div class="clearfix"></div>
    </div>
</form>

<hr>
<h2>Regras cadastradas</h2>
<hr>

<div id="regras-tipo-processo">
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>Titulo</th>
            <th>Descrição</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($tipo->regras as $regra)
            @include('tipo_processo.item_regra')
        @endforeach
        <tr id="sem-regras" class="{{ count($tipo->regras) > 0 ? 'hide' : '' }}">
            <td colspan="99">Nenhuma regra cadastrada.</td>
        </tr>
        </tbody>
    </table>
</div>