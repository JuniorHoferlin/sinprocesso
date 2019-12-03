<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalvarTipoProcessoRequest;
use App\Models\Formulario;
use App\Models\GrupoAcesso;
use App\Models\RegraProcesso;
use App\Models\Tarefa;
use App\Models\TipoProcesso;
use App\Models\TipoRegra;
use App\Relatorios\TipoProcessoListagem;

class TipoProcessoController extends Controller
{

    private $listagem;

    public function __construct(TipoProcessoListagem $listagem)
    {
        $this->listagem = $listagem;
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
        $formularios = Formulario::orderBy('titulo', 'ASC')->get();

        return view('tipo_processo.index', compact('dados', 'filtros', 'formularios'));
    }

    /**
     * Exibe a tela para adicionar um novo registro.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adicionar()
    {
        $formularios = Formulario::orderBy('titulo', 'ASC')->get();
        $gruposAcesso = GrupoAcesso::listarGruposAreas();

        return view('tipo_processo.adicionar', compact('formularios', 'gruposAcesso'));
    }

    /**
     * Adiciona um novo registro.
     *
     * @param SalvarTipoProcessoRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function salvar(SalvarTipoProcessoRequest $request)
    {
        $dados = $request->except('grupos');
        $tipo = TipoProcesso::create($dados);
        if ($tipo) {
            $tipo->gruposAcesso()->sync($request->get('grupos'));
            flash("Registro salvo com sucesso.", 'success');
        }

        return redirect()->route('tipo_processo.alterar', [$tipo->id, 'regras']);
    }

    /**
     * Exibe a tela para alterar os dados de um registro.
     *
     * @param int $id
     * @param string $aba
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function alterar($id, $aba = 'dados')
    {
        $tipo = TipoProcesso::with('regras', 'tarefas', 'gruposAcesso')->find($id);
        $formularios = Formulario::orderBy('titulo', 'ASC')->get();
        $tiposRegras = TipoRegra::orderBy('descricao', 'ASC')->get();
        $tarefas = Tarefa::naoExclusiva()->orderBy('identificador', 'ASC')->get();
        $gruposAcesso = GrupoAcesso::listarGruposAreas();

        return view('tipo_processo.alterar', compact('tipo', 'formularios', 'aba', 'tiposRegras', 'tarefas', 'gruposAcesso'));
    }

    /**
     * Altera os dados de um registro.
     *
     * @param int $id
     *
     * @param SalvarTipoProcessoRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function atualizar($id, SalvarTipoProcessoRequest $request)
    {
        $dados = $request->except('grupos');

        $tipo = TipoProcesso::find($id);
        $atualizado = $tipo->update($dados);
        if ($atualizado) {
            $tipo->gruposAcesso()->sync($request->get('grupos'));
            flash("Os dados do registro foram alterados com sucesso.", 'success');
        }

        return redirect()->route('tipo_processo.index');
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
        $excluido = TipoProcesso::find($id)->delete();
        if ($excluido) {
            flash("O registro foi excluído com sucesso.", 'success');
        }

        return redirect()->route('tipo_processo.index');
    }

    /**
     * Adiciona uma nova regra em um tipo de processo existente.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function adicionarRegra()
    {
        $regra = RegraProcesso::create(request()->all());
        $view = view('tipo_processo.item_regra', compact('regra'))->render();

        return response()->json($view);
    }

    /**
     * Exclui uma regra de um tipo de processo existente.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function removerRegra()
    {
        $id = request('id');
        $excluido = RegraProcesso::find($id)->delete();

        return response()->json($excluido);
    }

    /**
     * Associa/remove uma tarefa em um tipo de processo.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sincronizarTarefa()
    {
        if (!request()->ajax()) {
            abort(404);
        }

        $idTarefa = request('id_tarefa');
        $idTipo = request('id_tipo_processo');
        $tipo = TipoProcesso::with('tarefas')->find($idTipo);

        $associado = $tipo->associarTarefa($idTarefa);
        if (!$associado) {
            $retorno = ['mensagem' => 'Somente é permitido 1 tipo de tarefa COMPRA/ASSINATURA por tipo de processo.'];
        } else {
            $tipo = TipoProcesso::with('tarefas')->find($idTipo);
            $view = view('tipo_processo.ordem', compact('tipo'))->render();
            $retorno = ['view' => $view];
        }

        return response()->json($retorno);
    }

    /**
     * Ordena as tarefas na ordem que o usuário selecionou.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ordenarTarefas()
    {
        $idTipo = request('id_tipo_processo');
        $sequencial = request('sequencial');

        $ordenar = [];
        foreach ($sequencial as $idTarefa => $ordem) {
            $ordenar[$idTarefa] = ['ordem' => $ordem];
        }

        $tipo = TipoProcesso::find($idTipo);
        $retorno = $tipo->tarefas()->sync($ordenar);

        return response()->json(isset($retorno['attached']) ? true : false);
    }
}
