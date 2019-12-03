<h2 class="text-left">Campos do formulário
    <br>
    <small>Abaixo adicione campos que você irá precisar no formulário.</small>
</h2>
<hr>
<div class="row item form-group">
    <form action="{{ route('formularios.adicionar_campo') }}" class="validate" name="adicionar-campos">
        <div class="col-xs-6">
            <label>Nome do campo</label>
            <input type="text" name="label" class="form-control" required="">
        </div>

        <div class="col-xs-3">
            <label>Tipo de campo</label>
            <select name="id_tipo_campo" class="form-control" required="">
                <option></option>
                @foreach($tipos as $tipo)
                    <option value="{{ $tipo->id }}">{{ $tipo->descricao }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-xs-2">
            <label>Obrigatório</label>
            <select name="required" class="form-control" required="">
                <option value=""></option>
                <option value="S">Sim</option>
                <option value="N">Não</option>
            </select>
        </div>

        <div class="col-xs-1">
            <label>&nbsp;</label> <br>
            <button type="submit" class="btn btn-success btn-block">
                <i class="fa fa-plus"></i>
            </button>
        </div>
        <input type="hidden" name="id_formulario" value="{{ $formulario->id }}">
    </form>
</div>
<hr>
<h2 class="text-left">Campos adicionados
    <br>
    <small>Abaixo configure os campos que você já adicionou no formulário.</small>
</h2>

<div id="formularios-campos">
    <table class="table table-striped">
        <tbody>
        @forelse($campos as $campo)
            @include('formularios.item_campo', ['campo' => $campo])
        @empty
            <tr>
                <td id="sem-campo" colspan="99">Nenhum campo adicionado.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>