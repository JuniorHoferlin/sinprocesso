<h2>Regras do processo</h2>
<hr>

<table class="table table-bordered table-striped table-hover">
    <tr>
        <th width="1">Situação</th>
        <th width="400">Regra</th>
        <th>Descrição</th>
    </tr>
    @foreach($regras as $regra)
        <tr>
            <td style="vertical-align: middle;" class="validar-regras">
                <span class="text-nowrap">
                    <label class="radio-inline">
                        <input type="radio" required data-id="{{ $regra->id }}" name="regras[{{ $regra->id }}][situacao]" value="1">
                        Correto
                    </label>
                </span>

                <br>

                <span class="text-nowrap">
                    <label class="radio-inline">
                        <input type="radio" data-id="{{ $regra->id }}" name="regras[{{ $regra->id }}][situacao]" value="0">
                        Incorreto
                    </label>
                </span>
            </td>

            <td style="vertical-align: middle;">{{ $regra->titulo }}</td>
            <td style="vertical-align: middle;">{{ $regra->descricao }}</td>
        </tr>

        <tr id="regra-incorreta-{{ $regra->id }}" class="hide">
            <td colspan="3">
                <textarea name="regras[{{ $regra->id }}][descricao]" class="form-control" rows="3" placeholder="Porque esta regra não foi cumprida? descreva..."></textarea>
            </td>
        </tr>
    @endforeach
</table>