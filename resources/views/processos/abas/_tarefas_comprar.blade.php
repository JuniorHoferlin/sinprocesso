<h2 class="title">Insumos</h2>
<p>Selecione os insumos a serem comprados</p>
<hr style="margin: 5px 0px 10px;">
<table class="table table-bordered table-striped">
    @foreach($insumos as $i)
        <tr>
            <td class="text-left">{{ $i['produto'] }}</td>
            <td class="text-left" width="1">
                <select class="form-control comprar-produto-{{ request()->get('id')  }}" data-id="{{ $i['id']  }}">
                    <option value="0">Nenhum</option>
                    @for($qtd = $i['quantidade']; $qtd >= 1; $qtd--)
                        <option value="{{ $qtd }}">{{ $qtd }}</option>
                    @endfor
                </select>
            </td>
        </tr>
    @endforeach
</table>