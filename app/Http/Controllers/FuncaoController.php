<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalvarFuncaoRequest;
use App\Models\Area;
use App\Models\Funcao;
use App\Relatorios\FuncaoListagem;

class FuncaoController extends Controller
{

    private $listagem;

    public function __construct(FuncaoListagem $listagem)
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

        return view('funcoes.index', compact('dados', 'filtros'));
    }

    /**
     * Exibe a tela para adicionar um novo registro.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adicionar()
    {
        $areas = Area::listarAreasLeveis();

        return view('funcoes.adicionar', compact('areas'));
    }

    /**
     * Adiciona um novo registro.
     *
     * @param SalvarFuncaoRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function salvar(SalvarFuncaoRequest $request)
    {
        $funcao = Funcao::create($request->except('areas'));
        if ($funcao) {
            $funcao->areas()->sync($request->get('areas'));
            flash("Registro salvo com sucesso.", 'success');
        }

        return redirect()->route('funcoes.index');
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
        $funcao = Funcao::with('areas')->find($id);
        $areas = Area::listarAreasLeveis([], 0, $funcao->areas->pluck('id')->toArray());

        return view('funcoes.alterar', compact('funcao', 'areas'));
    }

    /**
     * Altera os dados de um registro.
     *
     * @param int $id
     *
     * @param SalvarFuncaoRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function atualizar($id, SalvarFuncaoRequest $request)
    {
        $funcao = Funcao::find($id);
        $atualizado = $funcao->update($request->except('areas'));
        if ($atualizado) {
            $funcao->areas()->sync($request->get('areas'));
            flash("Os dados do registro foram alterados com sucesso.", 'success');
        }

        return redirect()->route('funcoes.index');
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
        $excluido = Funcao::find($id)->delete();
        if ($excluido) {
            flash("O registro foi excluído com sucesso.", 'success');
        }

        return redirect()->route('funcoes.index');
    }
}
