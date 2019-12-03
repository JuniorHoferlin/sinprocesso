<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalvarTarefaRequest;
use App\Models\Anexo;
use App\Models\Area;
use App\Models\Comentario;
use App\Models\Formulario;
use App\Models\Insumo;
use App\Models\Modalidade;
use App\Models\Observacao;
use App\Models\PlanoAcao;
use App\Models\Processo;
use App\Models\Tarefa;
use App\Models\TermoReferencia;
use App\Models\TipoProcesso;
use App\Models\Usuario;
use App\Relatorios\ProcessoListagem;
use App\Services\ArquivoUploader;
use App\Services\CalculaDiasExecucao;
use App\Services\CarregaProcesso;
use App\Services\CriaProcesso;
use App\Services\GerenciaProcesso;
use DB;
use Log;

class ProcessoController extends Controller
{

    /**
     * @var CriaProcesso
     */
    private $criaProcesso;

    /**
     * @var ProcessoListagem
     */
    private $listagem;

    /**
     * @var ArquivoUploader
     */
    private $arquivoUploader;

    /**
     * @var CarregaProcesso
     */
    private $carregaProcesso;

    /**
     * @var GerenciaProcesso
     */
    private $gerenciaProcesso;

    /**
     * @var CalculaDiasExecucao
     */
    private $calculaDiasExecucao;

    public function __construct(
        CriaProcesso $criaProcesso,
        ProcessoListagem $listagem,
        ArquivoUploader $arquivoUploader,
        CarregaProcesso $carregaProcesso,
        GerenciaProcesso $gerenciaProcesso,
        CalculaDiasExecucao $calculaDiasExecucao
    ) {
        $this->criaProcesso = $criaProcesso;
        $this->listagem = $listagem;
        $this->arquivoUploader = $arquivoUploader;
        $this->carregaProcesso = $carregaProcesso;
        $this->gerenciaProcesso = $gerenciaProcesso;
        $this->calculaDiasExecucao = $calculaDiasExecucao;
    }

    /**
     * Lista todos os processos.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $filtros = request()->all();
        if (isset($filtros['acao']) && $filtros['acao'] == 'imprimir') {
            return $this->listagem->exportar($filtros);
        }

        $dados = $this->listagem->gerar($filtros);
        $status = Processo::$status;
        $modalidades = Modalidade::orderBy('descricao', 'ASC')->get();
        $areas = Area::listarAreasLeveis([], 0, [request('id_area')]);
        $tipos = Usuario::tiposDeProcesso();

        return view('processos.index', compact('dados', 'status', 'modalidades', 'areas', 'tipos'));
    }

    /**
     * Exibe a tela para adicionar um novo processo.
     *
     * @param int $idTipo ID do tipo de processo a ser adicionado.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function novo($idTipo)
    {
        $tipo = TipoProcesso::with('regras', 'formulario.campos.tipo')->find($idTipo);
        $tr = request('tr', null);

        // Caso o usuário tenha informado o termo de referência
        if ($tipo->tr == 'S' && !is_null($tr)) {
            $termo = TermoReferencia::where('codigo', $tr)->first();
            $insumosExistentes = Insumo::verificarInsumosAbertos($termo->id);
            if (count($insumosExistentes) == 0) {
                flash('Desculpe, mas todos os insumos desse termo de referência já foram abertos.', 'warning');
                redirect()->route('processos.index');
            }
        }

        $regras = $tipo->regras;
        $formulario = $tipo->formulario;
        $modalidades = Modalidade::orderBy('descricao', 'ASC')->get();

        return view('processos.novo', compact('tipo', 'regras', 'modalidades', 'formulario', 'insumosExistentes', 'tr', 'termo'));
    }

    /**
     * Rotina para salvar o processo.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function salvar()
    {
        try {
            DB::transaction(function () {
                $dados = request()->all();
                $processo = $this->criaProcesso->criar($dados);
                if ($processo) {
                    if ($processo->status == Processo::$status['BLOQUEADO']) {
                        flash('Processo aberto, porém ele foi bloqueado devido as regras não estarem cumpridas.', 'warning');
                    } else {
                        flash('Processo aberto com sucesso.', 'success');
                    }
                }
            });
        }
        catch (Exception $e) {
            flash('Houve um erro ao adicionar o processo, contate o suporte técnico.');
        }

        return redirect()->route('processos.index');
    }

    /**
     * Exibe os detalhes do processo por completo.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function visualizar($id)
    {
        $dados = $this->carregaProcesso->paraVisualizar($id);

        return view('processos.visualizar', $dados);
    }

    /**
     * Adiciona uma observação no processo.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function adicionarObservacao()
    {
        if (request()->method() != 'POST') {
            abort(404);
        }

        $idProcesso = request('id_processo');
        $descricao = request('descricao');

        $processo = Processo::with('observacoes')->find($idProcesso);
        $observacoes = $processo->adicionarObservacao($descricao);

        $view = view('processos.abas._observacao_itens', compact('observacoes'))->render();

        return response()->json($view);
    }

    /**
     * Remove uma observação de um processo.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function removerObservacao()
    {
        if (request()->method() != 'POST') {
            abort(404);
        }

        $observacao = Observacao::find(request('id'));
        $observacao->delete();

        $processo = Processo::with('observacoes')->find($observacao->id_processo);
        $observacoes = $processo->observacoes;
        $view = view('processos.abas._observacao_itens', compact('observacoes'))->render();

        return response()->json($view);
    }

    /**
     * Adiciona um comentário no processo.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function adicionarComentario()
    {
        if (request()->method() != 'POST') {
            abort(404);
        }

        $idProcesso = request('id_processo');
        $descricao = request('descricao');

        $processo = Processo::with('comentarios')->find($idProcesso);
        $comentarios = $processo->adicionarComentario($descricao);

        $view = view('processos.abas._comentario_itens', compact('comentarios'))->render();

        return response()->json($view);
    }

    /**
     * Remove um comentário de um processo.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function removerComentario()
    {
        if (request()->method() != 'POST') {
            abort(404);
        }

        $comentario = Comentario::find(request('id'));
        $comentario->delete();

        $processo = Processo::with('comentarios')->find($comentario->id_processo);
        $comentarios = $processo->comentarios;
        $view = view('processos.abas._comentario_itens', compact('comentarios'))->render();

        return response()->json($view);
    }

    /**
     * Salva a descrição do plano de ação do processo.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function salvarPlanoAcao()
    {
        $idPlano = request('id_plano_acao');
        $descricao = request('descricao');
        $plano = PlanoAcao::find($idPlano)->update(['descricao' => $descricao]);

        return response()->json($plano ? true : false);
    }

    /**
     * Salva os documentos selecionados pelo usuário no processo.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function salvarDocumentos()
    {
        $documentos = request('documentos', []);
        $idProcesso = request('id_processo');

        $retorno = 1;
        $processo = Processo::find($idProcesso);
        if (!$processo) {
            $retorno = 0;
        } else {
            $processo->documentos()->sync($documentos);
        }

        return response()->json($retorno);
    }

    /**
     * Adiciona um anexo ao processo.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function adicionarAnexos()
    {
        $idProcesso = request('id_processo');
        $titulo = request('titulo');
        $arquivo = request()->file('anexo');

        $processo = Processo::find($idProcesso);
        $arquivo = $this->arquivoUploader->upload($arquivo, 'anexos');
        if ($arquivo) {
            $anexo = $processo->anexos()->create(
                [
                    'titulo' => $titulo
                ]
            );
            $anexo->update(['anexo' => $arquivo]);
        } else {
            return response()->json(false);
        }

        $anexos = $processo->anexos;
        $view = view('processos.abas._anexos_itens', compact('anexos'))->render();

        return response()->json(['view' => $view]);
    }

    /**
     * Remove um anexo de um processo.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function removerAnexos()
    {
        $id = request('id');
        $anexo = Anexo::find($id);
        $anexo->delete();

        $processo = Processo::with('anexos')->find($anexo->id_processo);
        $anexos = $processo->anexos;
        $view = view('processos.abas._anexos_itens', compact('anexos'))->render();

        return response()->json(['view' => $view]);
    }

    /**
     * Carrega as tarefas do processo.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function carregarTarefas()
    {
        $id = request('id');
        $processo = Processo::with(['tarefas' => function ($q) {
            $q->with(['dados', 'historico']);
        }])->find($id);
        $processo->dias_execucao = $this->calculaDiasExecucao->diasExecucaoProcesso($processo);

        // Verifica se o processo está finalizado, caso sim retorna para recarregar a tela
        if ($processo->status == "FINALIZADO") {
            return response()->json("FINALIZADO");
        }

        // View de tarefas
        $nivel = 1;
        $sequencial = [1];
        $tarefas = $this->carregaProcesso->carregarTarefas($id);
        $tarefaView = view('processos.abas._tarefas_itens', compact('tarefas', 'nivel', 'sequencial', 'processo'))->render();

        // Progressbar
        $detalhesTarefas = $processo->detalhes_tarefas;
        $progressoView = view('processos.abas._progresso_processo', compact('detalhesTarefas', 'processo'))->render();

        // Painel
        $painelView = view('processos.abas._painel_itens', compact('tarefas', 'processo', 'nivel', 'sequencial'))->render();

        return response()->json(['tarefas' => $tarefaView, 'progresso' => $progressoView, 'painel' => $painelView]);
    }

    /**
     * Rotina para finalizar um processo.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function finalizar()
    {
        $id = request('id');

        try {
            $processo = Processo::find($id)->finalizar();
            if ($processo) {
                flash('Processo finalizado com sucesso.', 'success');
                $retorno = ['url' => route('processos.index')];
            }
        }
        catch (Exception $e) {
            $retorno = 0;
        }

        return response()->json($retorno);
    }

    /**
     * Envia o processo para Sala de Situação.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function enviarSalaSituacao()
    {
        try {
            $id = request('id');
            $retorno = $this->gerenciaProcesso->enviarSalaSituacao($id);
            if (!$retorno) {
                $retorno = ['mensagem' => "Houve um erro ao enviar o processo para sala de situação, contate o suporte técnico."];
            }
        }
        catch (Exception $e) {
            Log::error($e);
            $retorno = ['mensagem' => $e->getMessage()];
        }

        return response()->json($retorno);
    }

    /**
     * Exibe modal para adicionar uma nova tarefa que somente irá aparecer neste processo.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adicionarTarefa($id)
    {
        $processo = Processo::with('tarefas.dados')->find($id);
        $tarefas = $processo->tarefas;

        $areas = Area::listarAreasLeveis();
        $formularios = Formulario::orderBy('titulo', 'ASC')->get();
        $tipos = Tarefa::$tipos;
        $view = view('processos.abas._adicionar_tarefa', compact('areas', 'formularios', 'tipos', 'tarefas'))->render();

        return response()->json($view);
    }

    /**
     * Salva a tarefa que o usuário deseja adicionar no processo.
     *
     * @param SalvarTarefaRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function salvarTarefa(SalvarTarefaRequest $request)
    {
        try {
            $retorno = true;
            $dados = $request->all();
            $tarefa = $this->gerenciaProcesso->adicionarTarefa($dados);
            if (!$tarefa) {
                $retorno = ['mensagem' => 'Houve um erro ao adicionar a tarefa ao processo, contate o suporte técnico.'];
            }
        }
        catch (Exception $e) {
            Log::error($e);
            $retorno = ['mensagem' => $e->getMessage()];
        }

        return response()->json($retorno);
    }

}
