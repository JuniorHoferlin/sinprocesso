@extends('layouts.template')

@section('conteudo')
    <div class="lista panel panel-default">
        <div class="panel-body">
            <h1>Detalhes da auditoria</h1>
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                    <tr>
                        <td width="10%"><strong>Tipo da Rota:</strong></td>
                        <td>{{ $auditoria->tipo->descricao }}</td>
                    </tr>
                    <tr>
                        <td width="10%"><strong>Rota:</strong></td>
                        <td>{{ $auditoria->rota->descricao }}</td>
                    </tr>
                    <tr>
                        <td width="10%"><strong>Usuário:</strong></td>
                        <td>{{ $auditoria->usuario->login }}</td>
                    </tr>
                    <tr>
                        <td width="10%"><strong>Data:</strong></td>
                        <td>{{ formatarData($auditoria->created_at) }}</td>
                    </tr>
                    <tr>
                        <td width="10%"><strong>IP:</strong></td>
                        <td>{{ $auditoria->endereco_ipv4 }}</td>
                    </tr>
                    </tbody>
                </table>
                <br>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="control-group">
                            <label class="control-label">Dados $_GET:</label>

                            <div class="controls">
                                <pre json-viewer>{{ $auditoria->dados_get }}</pre>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="control-group">
                            <label class="control-label">Dados $_POST:</label>

                            <div class="controls">
                                <pre json-viewer>{{ $auditoria->dados_post }}</pre>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="control-group">
                            <label class="control-label">Dados $_SERVER:</label>

                            <div class="controls">
                                <pre json-viewer>{{ $auditoria->dados_server }}</pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="text-right">
                <a href="{{ route('auditoria.index') }}" class="btn btn-default">Voltar</a>
            </div>
        </div>
    </div>

    @foreach($auditoria->acoes as $acao)
        <div class="lista panel panel-default">
            <div class="panel-body">
                <h2>Ação #{{ $acao->id }}</h2>
                <div class="table-responsive">
                    <table class="table table-vertical-center table-primary table-thead-simple">
                        <tbody>
                        <tr>
                            <td width="30%"><strong>Tabela:</strong></td>
                            <td>{{ $acao->tabela }}</td>
                        </tr>
                        <tr>
                            <td width="30%"><strong>Registro:</strong></td>
                            <td>{{ $acao->id_registro }}</td>
                        </tr>
                        <tr>
                            <td width="30%"><strong>Ação na tabela:</strong></td>
                            <td>{{ $acao->acao_tabela_texto }}</td>
                        </tr>
                        </tbody>
                    </table>
                    <br>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="control-group">
                            <label class="control-label">Dados:</label>

                            <div class="controls">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <td><strong>Campo</strong></td>
                                        <td><strong>Antigo</strong></td>
                                        <td><strong>Novo</strong></td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($acao->dados_campos['campos'] as $campo)
                                        <tr>
                                            <td width="20%">{{ $campo }}</td>
                                            <td width="40%" {!! $acao->dados_campos['old'][$campo]['alterado'] ? 'style="font-weight: bold;"' : '' !!}>{{ $acao->dados_campos['old'][$campo]['valor'] }}</td>
                                            <td width="40%" {!! $acao->dados_campos['new'][$campo]['alterado'] ? 'style="font-weight: bold;"' : '' !!}>{{ $acao->dados_campos['new'][$campo]['valor'] }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection