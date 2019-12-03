<tr id="formulario-campo-{{ $campo->id }}">
    <td>
        <div class="form-group">
            <label>Nome do campo</label>
            <input type="text" value="{{ $campo->label }}" class="form-control" name="label">
        </div>
    </td>
    <td>
        <div class="form-group">
            <label>Tipo</label>
            <input type="text" value="{{ $campo->tipo->descricao }}" class="form-control" disabled="">
        </div>
    </td>
    <td>
        <div class="form-group">
            <label>Obrigatório</label>
            <select class="form-control" name="required">
                <option {{ $campo->required == 'S' ? 'selected' : '' }} value="S">Sim</option>
                <option {{ $campo->required == 'N' ? 'selected' : '' }} value="N">Não</option>
            </select>
        </div>
    </td>
    <td width="300">
        <div class="form-group">
            <label>Opções</label>
            <select class="form-control opcoes" multiple name="opcoes">
                @if ($campo->opcoes)
                    @foreach(json_decode($campo->opcoes) as $opcao)
                        <option selected>{{ $opcao }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </td>
    <td width="10%">
        <div class="form-group">
            <label>&nbsp;</label><br>
            <a href="{{ route('formularios.remover_campo') }}" data-id="{{ $campo->id }}" class="btn btn-danger excluir-campo">
                <i class="fa fa-close"></i>
            </a>
            <a href="{{ route('formularios.salvar_campo') }}" data-id="{{ $campo->id }}" class="btn btn-success salvar-campo">
                <i class="fa fa-save"></i>
            </a>
        </div>
    </td>
</tr>