<a href="javascript:;" title="Imprimir" class="btn btn-default">
    <i class="fa fa-print"></i>
</a>

<a href="javascript:;" title="Exportar" class="btn btn-default">
    <i class="fa fa-table"></i>
</a>

<?php /*  comentário feitodessa forma para não aparecer no source do html

<a target="_blank" href="{{ request()->fullUrl() }}{{ strpos(request()->fullUrl(), '?') !== false ? '&' : '?' }}acao=imprimir&relformato=pdf" title="Imprimir" class="btn btn-default">
    <i class="fa fa-print"></i>
</a>

<a target="_blank" href="{{ request()->fullUrl() }}{{ strpos(request()->fullUrl(), '?') !== false ? '&' : '?' }}acao=imprimir&relformato=xls" title="Exportar" class="btn btn-default">
    <i class="fa fa-table"></i>
</a> */ ?>

<button type="submit" title="Pesquisar" class="btn btn-default" name="acao" value="filtrar">
    <i class="fa fa-search"></i> Pesquisar
</button>