<select id="{{ $campo->id }}" class="form-control desativar-com-regra" name="formulario[{{ $campo->id }}]" {{ $campo->required == 'S' ? "required" : '' }}>
    <option></option>
    @foreach(json_decode($campo->opcoes) as $opcao)
        <option value="{{ $opcao }}">{{ $opcao }}</option>';
    @endforeach
</select>