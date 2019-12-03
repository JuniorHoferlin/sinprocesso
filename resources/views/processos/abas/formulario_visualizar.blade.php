<h2>{{ $formulario->titulo }}</h2>
<p>{{ $formulario->descricao }}</p>
<hr>

@foreach($respostasFormulario as $resposta)
    <div class="col-xs-12 form-group">
        <label>{{ $resposta->campo->label }}</label>
        <input type="text" disabled class="form-control" value="{{ $resposta->resposta_completa }}"/>
    </div>
@endforeach