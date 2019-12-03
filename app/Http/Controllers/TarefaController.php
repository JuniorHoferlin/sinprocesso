<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalvarTarefaRequest;
use App\Models\Area;
use App\Models\Comentario;
use App\Models\Formulario;
use App\Models\Observacao;
use App\Models\Processo;
use App\Models\Tarefa;
use App\Models\TarefaDocumento;
use App\Models\TarefaProcesso;
use App\Relatorios\TarefaListagem;
use App\Services\ArquivoUploader;
use App\Services\GerenciaProcesso;
use App\Services\ReportaTarefa;
use DB;
use Exception;

class TarefaController extends Controller
{

    private $listagem;

    /**
     * @var ReportaTarefa
     */
    private $reportaTarefa;

    /**
     * @var ArquivoUploader
     */
    private $arquivoUploader;

    /**
     * @var GerenciaProcesso
     */
    private $gerenciaProcesso;

    public function __construct(
        TarefaListagem $listagem,
        ReportaTarefa $reportaTarefa,
        ArquivoUploader $arquivoUploader,
        GerenciaProcesso $gerenciaProcesso
    )
    {
        $this->listagem = $listagem;
        $this->reportaTarefa = $reportaTarefa;
        $this->arquivoUploader = $arquivoUploader;
        $this->gerenciaProcesso = $gerenciaProcesso;
    }

    /**
     * Lista todos os registros do sistema.
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
        $tipos = Tarefa::$tipos;

        return view('tarefas.index', compact('dados', 'filtros', 'tipos'));
    }

    /**
     * Exibe a tela para adicionar um novo registro.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adicionar()
    {
        $tarefas = Tarefa::naoExclusiva()->orderBy('titulo', 'ASC')->get();
        $areas = Area::listarAreasLeveis();
        $formularios = Formulario::orderBy('titulo', 'ASC')->get();
        $tipos = Tarefa::$tipos;

        return view('tarefas.adicionar', compact('tarefas', 'areas', 'grupos', 'formularios', 'tipos'));
    }

    /**
     * Adiciona um novo registro.
     *
     * @param SalvarTarefaRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function salvar(SalvarTarefaRequest $request)
    {
        $tarefa = Tarefa::create($request->except('dependencias'));
        if ($tarefa) {
            $tarefa->dependencias()->sync($request->get('dependencias', []));
            flash("Registro salvo com sucesso.", 'success');
        }

        return redirect()->route('tarefas.index');
    }

    /**
     * Exibe a tela para alterar os dados de um registro.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function alterar($id)
    {
        $tarefa = Tarefa::with('dependencias')->find($id);

        $tarefas = Tarefa::naoExclusiva()->where('id', '<>', $tarefa->id)->orderBy('titulo', 'ASC')->get();
        $areas = Area::listarAreasLeveis([], 0, [$tarefa->id_area]);
        $tipos = Tarefa::$tipos;

        $grupos = [];
        $area = Area::with('gruposAcesso')->find($tarefa->id_area);
        $area->gruposAcesso->each(function ($grupo) use (&$grupos) {
            if ($grupo->super_admin == "N") {
                $grupos[] = [
                    'id' => $grupo->pivot->id,
                    'descricao' => $grupo->descricao
                ];
            }
        });

        $formularios = Formulario::orderBy('titulo', 'ASC')->get();

        return view('tarefas.alterar', compact('tarefa', 'tarefas', 'areas', 'grupos', 'formularios', 'tipos'));
    }

    /**
     * Altera os dados de um registro.
     *
     * @param int $id
     *
     * @param SalvarTarefaRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function atualizar($id, SalvarTarefaRequest $request)
    {
        $tarefa = Tarefa::find($id);
        $atualizado = $tarefa->update($request->except('dependencias'));
        if ($atualizado) {
            $tarefa->dependencias()->sync($request->get('dependencias', []));
            flash("Os dados do registro foram alterados com sucesso.", 'success');
        }

        return redirect()->route('tarefas.index');
    }

    /**
     * Exclui um registro.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function excluir($id)
    {
        $excluido = Tarefa::find($id)->delete();
        if ($excluido) {
            flash("O registro foi excluído com sucesso.", 'success');
        }

        return redirect()->route('tarefas.index');
    }

    /**
     * Carrega os grupo de acesso da area selecionada.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function carregaGrupoAcesso()
    {
        $id = request()->get('id');
        $area = Area::with('gruposAcesso')->find($id);

        $retorno = [];
        $area->gruposAcesso->each(function ($grupo) use (&$retorno) {
            if ($grupo->super_admin == "N") {
                $retorno[] = [
                    'id' => $grupo->pivot->id,
                    'descricao' => $grupo->descricao
                ];
            }
        });

        return response()->json($retorno);
    }

    /**
     * Rotina para iniciar uma tarefa.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function iniciarTarefa()
    {
        $id = request('id'); // id da tarefa processo

        try {
            DB::transaction(function () use ($id, &$retorno) {
                $retorno = $this->gerenciaProcesso->iniciarTarefa($id);
            });
        } catch (Exception $e) {
            $retorno = ['mensagem' => $e->getMessage()];
        }

        return response()->json($retorno);
    }

    /**
     * Rotina para finalizar uma tarefa.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function finalizarTarefa()
    {
        $id = request('id'); // id da tarefa processo

        try {
            $tarefa = TarefaProcesso::find($id);

            $retorno = $this->gerenciaProcesso->finalizarTarefa($tarefa->id);

        } catch (Exception $e) {
            $retorno = false;
        }

        return response()->json($retorno);
    }

    /**
     * Carrega as tarefas para poder reporta-las.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function carregarParaReportar()
    {
        $id = request('id');
        $tarefa = TarefaProcesso::find($id);

        $tarefas = TarefaProcesso::carregarParaReportar($tarefa);
        if ($tarefas) {
            $view = view('processos.abas._tarefas_reportar', compact('tarefas'))->render();
        } else {
            $view = false;
        }

        return response()->json($view);
    }

    /**
     * Carrega as tarefas para poder efetuar a compra.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function carregarParaComprar()
    {
        $id = request('id');
        $tarefa = TarefaProcesso::find($id);

        $insumos = TarefaProcesso::carregarInsumosParaComprar($tarefa);
        if ($insumos) {
            $view = view('processos.abas._tarefas_comprar', compact('insumos'))->render();
        } else {
            $view = false;
        }

        return response()->json($view);
    }

    /**
     * Rotina para reportar uma tarefa.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function reportarTarefa()
    {
        $id = request('id'); // id da tarefa processo
        $tarefas = request('tarefas'); // tarefas a serem reportadas

        try {
            DB::transaction(function () use ($id, $tarefas, &$retorno) {
                $retorno = $this->gerenciaProcesso->reportarTarefa($id, $tarefas);
            });
        } catch (Exception $e) {
            $retorno = false;
        }

        return response()->json($retorno);
    }

    /**
     * Rotina para comprar os insumos.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function efetuarCompra()
    {
        $id = request('id');
        $insumos = request('insumos');
        $retorno = [];
        try {
            $tarefa = TarefaProcesso::find($id);
            DB::transaction(function () use ($tarefa, &$retorno, $id, $insumos) {
                $tarefa->insumos()->syncWithoutDetaching($insumos);
                $proxima = $tarefa->sala_situacao == "S" ? false : true;
                $this->gerenciaProcesso->finalizarTarefa($id, $proxima);
                #if ($this->gerenciaProcesso->verificarExistenciaInsumosPendentes($tarefa->id_processo)) {
                #    $this->gerenciaProcesso->abrirTarefaCompra($tarefa->id);
                #}
                $retorno = true;
            });
        } catch (Exception $e) {
            $retorno = false;
        }

        return response()->json($retorno);
    }

    /**
     * Retorna todos os documentos associados a uma tarefa.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function documentos($id)
    {
        $tarefa = TarefaProcesso::with('dados', 'historico')->find($id);
        $documentos = TarefaDocumento::with('usuario')->where('id_tarefa_processo', $id)->get();
        $view = view('processos.abas._tarefas_documentos', compact('documentos', 'tarefa'))->render();

        return $view;
    }

    /**
     * Retorna todas as observações de uma tarefa.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function observacoes($id)
    {
        $tarefa = TarefaProcesso::with('dados', 'historico')->find($id);
        $observacoes = Observacao::where('id_tarefa_processo', $id)->get();
        $view = view('processos.abas._tarefas_observacoes', compact('observacoes', 'tarefa'))->render();

        return $view;
    }

    /**
     * Retorna todos os comentários de uma tarefa.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function comentarios($id)
    {
        $tarefa = TarefaProcesso::with('dados', 'historico')->find($id);
        $comentarios = Comentario::where('id_tarefa_processo', $id)->get();
        $view = view('processos.abas._tarefas_comentarios', compact('comentarios', 'tarefa'))->render();

        return $view;
    }

    /**
     * Retorna todos os insumos de uma tarefa.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function insumos($id)
    {
        $tarefa = TarefaProcesso::with('insumos.insumoTermo.insumo')->find($id);
        $view = view('processos.abas._tarefas_insumos_visualizar', compact('tarefa'))->render();

        return $view;
    }

    /**
     * Adiciona um documento a tarefa.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function adicionarDocumento()
    {
        if (request()->method() != 'POST') {
            abort(404);
        }

        $idTarefa = request('id_tarefa_processo');
        $titulo = request('titulo');
        $arquivo = request()->file('anexo');

        // Primeiro faz upload do arquivo
        $arquivo = $this->arquivoUploader->upload($arquivo, 'documento_tarefa');
        if ($arquivo) {
            $tarefa = TarefaProcesso::with('dados', 'historico')->find($idTarefa);
            $documento = $tarefa->documentos()->create(
                [
                    'titulo' => $titulo,
                    'id_usuario' => auth()->user()->id
                ]
            );
            if ($documento) {
                $documento->update(['anexo' => $arquivo]);
            }
        } else {
            return response()->json(false);
        }

        $documentos = $tarefa->documentos;
        $view = view('processos.abas._tarefas_documentos_itens', compact('documentos', 'tarefa'))->render();

        return response()->json(['view' => $view]);
    }

    /**
     * Remove um documento de uma tarefa.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function removerDocumento()
    {
        if (request()->method() != 'POST') {
            abort(404);
        }

        $id = request('id');
        $documento = TarefaDocumento::find($id);
        if ($documento) {
            $documento->delete();
        }

        $tarefa = TarefaProcesso::with('dados', 'documentos', 'historico')->find($documento->id_tarefa_processo);
        $documentos = $tarefa->documentos;
        $view = view('processos.abas._tarefas_documentos_itens', compact('documentos', 'tarefa'))->render();

        return response()->json(['view' => $view]);
    }

    /**
     * Adiciona uma observação na tarefa.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function adicionarObservacao()
    {
        if (request()->method() != 'POST') {
            abort(404);
        }

        $idTarefa = request('id_tarefa_processo');
        $idProcesso = request('id_processo');
        $descricao = request('descricao');

        Observacao::create(['descricao' => $descricao, 'id_tarefa_processo' => $idTarefa, 'id_processo' => $idProcesso]);

        $tarefa = TarefaProcesso::with(['observacoes', 'dados', 'historico'])->find($idTarefa);
        $observacoes = $tarefa->observacoes;

        $view = view('processos.abas._tarefas_observacoes_itens', compact('observacoes', 'tarefa'))->render();

        return response()->json($view);
    }

    /**
     * Remove uma observação de uma tarefa.
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

        $tarefa = TarefaProcesso::with(['observacoes', 'dados', 'historico'])->find($observacao->id_tarefa_processo);
        $observacoes = $tarefa->observacoes;
        $view = view('processos.abas._tarefas_observacoes_itens', compact('observacoes', 'tarefa'))->render();

        return response()->json($view);
    }

    /**
     * Adiciona um comentário na tarefa.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function adicionarComentario()
    {
        if (request()->method() != 'POST') {
            abort(404);
        }

        $idTarefa = request('id_tarefa_processo');
        $idProcesso = request('id_processo');
        $descricao = request('descricao');

        Comentario::create(['descricao' => $descricao, 'id_tarefa_processo' => $idTarefa, 'id_processo' => $idProcesso]);

        $tarefa = TarefaProcesso::with(['comentarios', 'dados', 'historico'])->find($idTarefa);
        $comentarios = $tarefa->comentarios;

        $view = view('processos.abas._tarefas_comentarios_itens', compact('comentarios', 'tarefa'))->render();

        return response()->json($view);
    }

    /**
     * Remove um comentário de uma tarefa.
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

        $tarefa = TarefaProcesso::with(['comentarios', 'dados', 'historico'])->find($comentario->id_tarefa_processo);
        $comentarios = $tarefa->comentarios;
        $view = view('processos.abas._tarefas_comentarios_itens', compact('comentarios', 'tarefa'))->render();

        return response()->json($view);
    }

}
