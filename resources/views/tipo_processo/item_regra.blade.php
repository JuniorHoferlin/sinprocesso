<tr id="regra-{{ $regra->id }}">
    <td>{{ $regra->titulo }}</td>
    <td>{{ $regra->descricao }}</td>
    <td width="1">
        <a href="{{ route('tipo_processo.remover_regra') }}" data-id="{{ $regra->id }}" class="btn btn-danger btn-xs excluir-regra">
            <i class="fa fa-close"></i>
        </a>
    </td>
</tr>