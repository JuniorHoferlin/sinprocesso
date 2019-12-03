<input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="form-group">
    <label for="codigo">
        TR
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Exemplo: 123456" is="numeric" value="{{ isset($termoReferencia) ? $termoReferencia->codigo : '' }}"/>
</div>

<div class="form-group">
    <label for="assunto">
        Assunto
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <input type="text" class="form-control" name="assunto" id="assunto" placeholder="Exemplo: solicitação de prestação de serviços para alguma coisa" is="required" value="{{ isset($termoReferencia) ? $termoReferencia->assunto : '' }}"/>
</div>

<div class="form-group">
    <label for="diretoria">
        Diretoria
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <textarea class="form-control" name="diretoria" id="diretoria" rows="4" is="required">{{ isset($termoReferencia) ? $termoReferencia->diretoria : '' }}</textarea>
</div>

<div class="form-group">
    <label for="fonte_recurso">
        Fonte de recurso
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <textarea class="form-control" name="fonte_recurso" id="fonte_recurso" rows="4" is="required">{{ isset($termoReferencia) ? $termoReferencia->fonte_recurso : '' }}</textarea>
</div>

<div class="form-group">
    <label for="classificacao_orcamento">
        Classificação do orçamento
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <textarea class="form-control" name="classificacao_orcamento" id="classificacao_orcamento" rows="4" is="required">{{ isset($termoReferencia) ? $termoReferencia->classificacao_orcamento : '' }}</textarea>
</div>

<div class="form-group">
    <label for="natureza_despesa">
        Natureza da despesa
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <textarea class="form-control" name="natureza_despesa" id="natureza_despesa" rows="4" is="required">{{ isset($termoReferencia) ? $termoReferencia->natureza_despesa : '' }}</textarea>
</div>

<div class="form-group">
    <label for="bloco">
        Bloco
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <textarea class="form-control" name="bloco" id="bloco" rows="4" is="required">{{ isset($termoReferencia) ? $termoReferencia->bloco : '' }}</textarea>
</div>

<div class="form-group">
    <label for="componente">
        Componente
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <textarea class="form-control" name="componente" id="componente" rows="4" is="required">{{ isset($termoReferencia) ? $termoReferencia->componente : '' }}</textarea>
</div>

<div class="form-group">
    <label for="acao">
        Ação
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <textarea class="form-control" name="acao" id="acao" rows="4" is="required">{{ isset($termoReferencia) ? $termoReferencia->acao : '' }}</textarea>
</div>

<div class="form-group">
    <label for="programa_ppa">
        Programa PPA
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <textarea class="form-control" name="programa_ppa" id="programa_ppa" rows="4" is="required">{{ isset($termoReferencia) ? $termoReferencia->programa_ppa : '' }}</textarea>
</div>

<div class="form-group">
    <label for="ata_regristro_preco">
        Ata do registro de preço
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <textarea class="form-control" name="ata_regristro_preco" id="ata_regristro_preco" rows="4" is="required">{{ isset($termoReferencia) ? $termoReferencia->ata_regristro_preco : '' }}</textarea>
</div>

<div class="form-group">
    <label for="anexo">
        Anexo da TR
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    @include('partials.botao_anexar_arquivo_simples', ['nome' => 'anexo', 'nomeArquivo' => isset($termoReferencia) ? $termoReferencia->anexo : '', 'required' => !isset($termoReferencia) ? true : false])
</div>