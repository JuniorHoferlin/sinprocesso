@foreach (json_decode($campo->opcoes) as $opcao)
    <label class="checkbox-inline">
        <input type="checkbox" class="desativar-com-regra" {{ $campo->required == 'S' ? "data-pelo-menos='true'" : '' }} id="{{ $campo->id }}" value="{{ $opcao }}" name="formulario[{{ $campo->id }}][]">
        {{ $opcao }}
    </label>
@endforeach