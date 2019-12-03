@section('styles')
    @parent
    <style>
        /* Pequeno hack para este div dar destaque no popover */
        #overlay-popover {
            display: none;
            position: fixed;
            left: 0px;
            top: 0px;
            height: 100%;
            width: 100%;
            background: #000;
            opacity: 0.4;
            z-index: 1006;
        }
    </style>
@stop

<h2 class="text-left">
    <small>Modifique os insumos adicionados à este termo de referência.</small>
</h2>

<hr/>

<div class="alert alert-info {{ count($termoReferencia->insumos)>0 ? "hide":"" }}">
    <p>Nenhum insumo foi adicionado</p>
</div>

<div class="alert alert-warning {{ count($termoReferencia->insumos) > 0 ? "" : "hide" }}">
    <p>Não é possivel remover insumos que estejam com tramite de processo.</p>
</div>

<table class="table table-hover table-bordered {{ count($termoReferencia->insumos)>0 ? "":"hide" }} ">
    <tr>
        <th>Insumo</th>
        <th width="130" colspan="3">Solicitado</th>
        <th width="120">Em processo</th>
        <th width="170">Média de consumo</th>
        <th width="130">Valor unitário</th>
        <th width="130">Total</th>
    </tr>

    <tbody>
    @php($totalFinal = 0)
    @foreach($termoReferencia->insumos as $insumo)
        <tr id="insumo-adicionado-{{$insumo->id}}">
            <td>{{$insumo->produto}}</td>
            @if($insumo->adicionadoPosteriormente==1)
                <td width="1">
                    <a href="{{ request()->root() . "/termo-referencia/visualizar-insumos-adicionados/" . $insumo->pivot->id }}" data-toggle="modal" data-target="#modal">
                        <i class="fa fa-exclamation-circle"></i>
                    </a>
                </td>
            @endif
            <td colspan="{{ $insumo->adicionadoPosteriormente == 1 ? 1 : 2 }}" width="80">
                {{$insumo->pivot->quantidade}}
            </td>
            <td width="1">
                <button type="button" data-id="{{$insumo->pivot->id}}" onclick="acrescentarQuantidade($(this))" class="popover-btn-qtd btn btn-xs btn-primary">
                    <i class="fa fa-plus"></i>
                </button>
            </td>
            <td>{{$insumo->quantidadeEmProcesso}}</td>
            <td>{{$insumo->pivot->media_consumo}}</td>
            <td>{{formatarDinheiro ($insumo->pivot->valor)}}</td>
            <td>{{formatarDinheiro ($insumo->pivot->valor * $insumo->pivot->quantidade)}}</td>
        </tr>
        @php($totalFinal = $totalFinal + $insumo->pivot->valor * $insumo->pivot->quantidade)
    @endforeach
    </tbody>
</table>
<hr>

<h1 class="text-right   ">
    <small>Total final</small>
    <br>
    <strong>{{formatarDinheiro($totalFinal)}}</strong>
</h1>

<div id="overlay-popover"></div>