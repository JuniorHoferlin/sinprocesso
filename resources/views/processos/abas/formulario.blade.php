<br>

<h2>{{ $formulario->titulo }}</h2>
<p>{{ $formulario->descricao }}</p>

<hr>

<div class="well">
    @foreach($formulario->campos as $campo)
        <div class="col-md-12">
            <div class="form-group">
                <label for="{{ $campo->id }}">
                    {{ $campo->label }}
                    @if ($campo->required == 'S')
                        <small><i class="fa fa-asterisk"></i></small>
                    @endif
                </label>
                <br>
                {!! $campo->renderizar() !!}
            </div>
        </div>
    @endforeach
    <div class="clearfix"></div>
</div>