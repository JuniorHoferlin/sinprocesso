@forelse($dados as $dado)
    <div class="faq-item">
        <div class="row">
            <div class="col-md-9">
                <a data-toggle="collapse" href="#chamado-{{ $dado->id }}" class="faq-question">
                    {{ $dado->titulo }}
                    <small class="block text-muted">(clique para ver detalhes do chamado)</small>
                </a>
            </div>
            <div class="col-md-3 text-right m-t-xs">
                <div><span class="small font-bold">{{ formatarDataExtenso($dado->created_at)  }}</span></div>
                <div>
                    <span class="small text-info">PENDENTE</span>
                    <span class="small text-success">RESPONDIDO</span>
                    <span class="small text-danger">FECHADO</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div id="chamado-{{ $dado->id }}" class="panel-collapse collapse ">
                    <div class="faq-answer">
                        <p>{{ $dado->descricao }}</p>
                    </div>
                    <div class="m-t-xs text-right">
                        <a href="#" class="btn btn-info btn-xs">Comentários</a>
                    </div>
                </div>
            </div>
        </div>
    </div>




    {{--<tr>--}}
    {{--<td></td>--}}
    {{--<td></td>--}}
    {{--<td>{{ $dado->problema_relatado }}</td>--}}
    {{--<td>{{ $dado->solucao }}</td>--}}
    {{--@if (!isset($imprimir))--}}
    {{--@can('suporte.alterar')--}}
    {{--<td>--}}
    {{--@include('partials.botao_editar', ['url' => route('suporte.alterar', $dado->id)])--}}
    {{--</td>--}}
    {{--@endcan--}}
    {{--@can('suporte.excluir')--}}
    {{--<td>--}}
    {{--@include('partials.botao_excluir', ['url' => route('suporte.excluir', $dado->id)])--}}
    {{--</td>--}}
    {{--@endcan--}}
    {{--@endif--}}
    {{--</tr>--}}
@empty
    <div class="alert alert-info">
        <p>Nenhum chamado técnico foi encontrado.</p>
    </div>
@endforelse