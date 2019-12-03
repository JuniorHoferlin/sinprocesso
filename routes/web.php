<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Rotas do sistema.
|
*/

// Rotas de login, não precisam de autorização
Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
Route::post('login', ['as' => 'login.post', 'uses' => 'Auth\LoginController@login']);
Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
Route::get('esqueci', ['as' => 'esqueci', 'uses' => 'Auth\ResetPasswordController@showResetForm']);
Route::post('esqueci', ['as' => 'esqueci.post', 'uses' => 'Auth\ResetPasswordController@reset']);
Route::get('nao-autorizado', function () {
    return view('erros.nao_autorizado');
})->name('nao_autorizado');

/**
 * Rotas que necessitam de autenticação
 */
Route::group(['middleware' => ['auth', 'necessita-permissao', 'auditoria']], function () {
    Route::get('/', ['uses' => 'HomeController@index', 'as' => 'home']);
    Route::post('dados-dashboard/{periodo?}', ['uses' => 'HomeController@buscarDadosDashboard', 'as' => 'home.buscar_dados_dashboard']);
    Route::get('minhas-tarefas', ['uses' => 'UsuarioController@minhasTarefas', 'as' => 'minhas_tarefas']);

    // Auditoria
    Route::group(['prefix' => 'auditoria', 'as' => 'auditoria.'], function () {
        Route::get('/', ['uses' => 'AuditoriaController@index', 'as' => 'index']);
        Route::get('visualizar/{id}', ['uses' => 'AuditoriaController@visualizar', 'as' => 'visualizar']);
    });

    // Processos
    Route::group(['prefix' => 'processos', 'as' => 'processos.'], function () {
        Route::get('/', ['uses' => "ProcessoController@index", 'as' => 'index']);
        Route::get('novo/{idTipo}', ['uses' => "ProcessoController@novo", 'as' => 'novo']);
        Route::post('novo', ['uses' => "ProcessoController@salvar", 'as' => 'novo.post']);
        Route::get('visualizar/{id}', ['uses' => "ProcessoController@visualizar", 'as' => 'visualizar']);
        Route::post('adicionar-observacao', ['uses' => "ProcessoController@adicionarObservacao", 'as' => 'adicionar_observacao']);
        Route::post('remover-observacao', ['uses' => "ProcessoController@removerObservacao", 'as' => 'remover_observacao']);
        Route::post('salvar-plano-acao', ['uses' => "ProcessoController@salvarPlanoAcao", 'as' => 'salvar_plano_acao']);
        Route::post('salvar-documentos', ['uses' => "ProcessoController@salvarDocumentos", 'as' => 'salvar_documentos']);
        Route::post('adicionar-anexo', ['uses' => "ProcessoController@adicionarAnexos", 'as' => 'adicionar_anexos']);
        Route::post('remover-anexo', ['uses' => "ProcessoController@removerAnexos", 'as' => 'remover_anexos']);
        Route::post('carregar-tarefas', ['uses' => "ProcessoController@carregarTarefas", 'as' => 'carregar_tarefas']);
        Route::post('finalizar', ['uses' => "ProcessoController@finalizar", 'as' => 'finalizar']);
        Route::post('adicionar-comentario', ['uses' => "ProcessoController@adicionarComentario", 'as' => 'adicionar_comentario']);
        Route::post('remover-comentario', ['uses' => "ProcessoController@removerComentario", 'as' => 'remover_comentario']);
        Route::post('enviar-sala-situacao', ['uses' => "ProcessoController@enviarSalaSituacao", 'as' => 'enviar_sala_situacao']);
        Route::get('adicionar-tarefa/{id}', ['uses' => "ProcessoController@adicionarTarefa", 'as' => 'adicionar_tarefa_exclusiva']);
        Route::post('adicionar-tarefa', ['uses' => "ProcessoController@salvarTarefa", 'as' => 'adicionar_tarefa_exclusiva.post']);
    });

    // Formulários
    Route::group(['prefix' => 'formularios', 'as' => 'formularios.'], function () {
        rotasCrud('FormularioController');
        Route::get('alterar/{id}/{aba?}', ['uses' => "FormularioController@alterar", 'as' => 'alterar']);
        Route::post('adicionar-campo', ['uses' => "FormularioController@adicionarCampo", 'as' => 'adicionar_campo']);
        Route::post('remover-campo', ['uses' => "FormularioController@removerCampo", 'as' => 'remover_campo']);
        Route::post('salvar-campo', ['uses' => "FormularioController@salvarCampo", 'as' => 'salvar_campo']);
    });

    // Tarefas
    Route::group(['prefix' => 'tarefas', 'as' => 'tarefas.'], function () {
        rotasCrud('TarefaController');
        Route::post('carrega-grupo-acesso', ['uses' => "TarefaController@carregaGrupoAcesso", 'as' => 'carrega_grupo_acesso']);
        Route::post('iniciar', ['uses' => "TarefaController@iniciarTarefa", 'as' => 'iniciar_tarefa_processo']);
        Route::post('finalizar', ['uses' => "TarefaController@finalizarTarefa", 'as' => 'finalizar_tarefa_processo']);
        Route::post('carregar-para-reportar', ['uses' => "TarefaController@carregarParaReportar", 'as' => 'carregar_para_reportar']);
        Route::post('carregar-para-comprar', ['uses' => "TarefaController@carregarParaComprar", 'as' => 'carregar_para_comprar']);
        Route::post('reportar', ['uses' => "TarefaController@reportarTarefa", 'as' => 'reportar_tarefa_processo']);
        Route::post('comprar', ['uses' => "TarefaController@efetuarCompra", 'as' => 'comprar_tarefa_processo']);
        Route::get('documentos/{id}', ['uses' => "TarefaController@documentos", 'as' => 'visualizar_documentos_processo']);
        Route::get('observacoes/{id}', ['uses' => "TarefaController@observacoes", 'as' => 'visualizar_observacoes_processo']);
        Route::get('comentarios/{id}', ['uses' => "TarefaController@comentarios", 'as' => 'visualizar_comentarios_processo']);
        Route::get('insumos/{id}', ['uses' => "TarefaController@insumos", 'as' => 'visualizar_insumos_processo']);
        Route::post('adicionar-documento', ['uses' => "TarefaController@adicionarDocumento", 'as' => 'adicionar_documento']);
        Route::post('remover-documento', ['uses' => "TarefaController@removerDocumento", 'as' => 'remover_documento']);
        Route::post('adicionar-observacao', ['uses' => "TarefaController@adicionarObservacao", 'as' => 'adicionar_observacao']);
        Route::post('remover-observacao', ['uses' => "TarefaController@removerObservacao", 'as' => 'remover_observacao']);
        Route::post('adicionar-comentario', ['uses' => "TarefaController@adicionarComentario", 'as' => 'adicionar_comentario']);
        Route::post('remover-comentario', ['uses' => "TarefaController@removerComentario", 'as' => 'remover_comentario']);
    });

    // Documentos Padrão
    Route::group(['prefix' => 'documentos-padrao', 'as' => 'documento_padrao.'], function () {
        rotasCrud('DocumentoPadraoController');
    });

    // Usuários
    Route::group(['prefix' => 'usuarios', 'as' => 'usuarios.'], function () {
        rotasCrud('UsuarioController');
        Route::post('carrega-cidades', ['uses' => 'UsuarioController@carregarCidades', 'as' => 'carregar_cidades']);
        Route::get('alterar-status/{id}', ['uses' => 'UsuarioController@alterarStatus', 'as' => 'alterar_status']);
    });

    // Funções
    Route::group(['prefix' => 'funcoes', 'as' => 'funcoes.'], function () {
        rotasCrud('FuncaoController');
    });

    // Áreas
    Route::group(['prefix' => 'areas', 'as' => 'areas.'], function () {
        rotasCrud('AreaController');
    });

    // Grupos de acesso
    Route::group(['prefix' => 'grupos-acesso', 'as' => 'grupo_acesso.'], function () {
        rotasCrud('GrupoAcessoController');
        Route::post('carregar-permissoes', ['uses' => 'GrupoAcessoController@carregarPermissoes', 'as' => 'carregar_permissoes']);
        Route::get('gerenciar-permissoes', ['uses' => 'GrupoAcessoController@gerenciarPermissoes', 'as' => 'gerenciar_permissoes']);
        Route::post('gerenciar-permissoes', ['uses' => 'GrupoAcessoController@salvarPermissoes', 'as' => 'gerenciar_permissoes.post']);
    });

    // Feriados
    Route::group(['prefix' => 'feriados', 'as' => 'feriados.'], function () {
        rotasCrud('FeriadoController');
    });

    // Permissões: Tipos de rotas
    Route::group(['prefix' => 'tipos-rotas', 'as' => 'tipos_rotas.'], function () {
        rotasCrud('TipoRotaController');
    });

    // Permissões: Rotas
    Route::group(['prefix' => 'rotas', 'as' => 'rotas.'], function () {
        rotasCrud('RotaController');
    });

    // Tipos de regra
    Route::group(['prefix' => 'tipo-regra', 'as' => 'tipo_regra.'], function () {
        rotasCrud('TipoRegraController');
    });

    // Insumo
    Route::group(['prefix' => 'insumo', 'as' => 'insumo.'], function () {
        rotasCrud('InsumoController');
    });

    // Modalidade
    Route::group(['prefix' => 'modalidade', 'as' => 'modalidade.'], function () {
        rotasCrud('ModalidadeController');
    });

    // Tipos de processo
    Route::group(['prefix' => 'tipo-processo', 'as' => 'tipo_processo.'], function () {
        rotasCrud('TipoProcessoController');
        Route::get('alterar/{id}/{aba?}', ['uses' => "TipoProcessoController@alterar", 'as' => 'alterar']);
        Route::post('adicionar-regra', ['uses' => "TipoProcessoController@adicionarRegra", 'as' => 'adicionar_regra']);
        Route::post('remover-regra', ['uses' => "TipoProcessoController@removerRegra", 'as' => 'remover_regra']);
        Route::post('sincronizar-tarefa', ['uses' => "TipoProcessoController@sincronizarTarefa", 'as' => 'sicronizar_tarefa']);
        Route::post('ordenar-tarefas', ['uses' => "TipoProcessoController@ordenarTarefas", 'as' => 'ordernar_tarefas']);
    });

    // Termo de referência
    Route::group(['prefix' => 'termo-referencia', 'as' => 'termo_referencia.'], function () {
        rotasCrud('TermoReferenciaController');
        Route::get('adicionar/{aba?}', ['uses' => "TermoReferenciaController@adicionar", 'as' => 'adicionar']);
        Route::get('alterar/{id}/{aba?}', ['uses' => "TermoReferenciaController@alterar", 'as' => 'alterar']);
        Route::post('procurar', ['uses' => "TermoReferenciaController@procurar", 'as' => 'procurar']);
        Route::post('acrescentar-insumo', ['uses' => "TermoReferenciaController@acrescentar_insumo", 'as' => 'acrescentar_insumo']);
        Route::post('acrescentar-insumo-salvar', ['uses' => "TermoReferenciaController@acrescentar_insumo_salvar", 'as' => 'acrescentar_insumo_salvar']);
        Route::get('visualizar-insumos-adicionados/{id}', ['uses' => "TermoReferenciaController@ver_insumos_adicionados", 'as' => 'ver_insumos_adicionados']);
    });

    // Relatórios: Andamento de Tarefas
    Route::group(['prefix' => 'andamento-tarefas', 'as' => 'andamento_tarefa.'], function () {
        Route::get('/', ['uses' => "Relatorios\\AndamentoTarefaController@index", 'as' => 'index']);
    });

    // Relatórios: Informações por area
    Route::group(['prefix' => 'informacao-area', 'as' => 'informacao_area.'], function () {
        Route::get('/', ['uses' => "Relatorios\\InformacaoAreaController@index", 'as' => 'index']);
    });

    // Relatórios: Informações por area
    Route::group(['prefix' => 'insumo-processo', 'as' => 'insumo_processo.'], function () {
        Route::get('/', ['uses' => "Relatorios\\InsumoProcessoController@index", 'as' => 'index']);
        Route::get('ver/{idProcesso}', ['uses' => "Relatorios\\InsumoProcessoController@ver", 'as' => 'ver']);
    });

    // Suporte
    Route::group(['prefix' => 'suporte', 'as' => 'suporte.'], function () {
        rotasCrud('ChamadoTecnicoController');
    });
});
