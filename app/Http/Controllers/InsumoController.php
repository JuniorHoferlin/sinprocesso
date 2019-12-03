<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalvarInsumoRequest;
use App\Models\Insumo;
use App\Relatorios\InsumoListagem;

class InsumoController extends Controller
{

    private $listagem;

    public function __construct(InsumoListagem $listagem)
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

        return view('insumo.index', compact('dados', 'filtros'));
    }

    /**
     * Exibe a tela para adicionar um novo registro.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adicionar()
    {
        return view('insumo.adicionar');
    }

    /**
     * Adiciona um novo registro.
     *
     * @param SalvarInsumoRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function salvar(SalvarInsumoRequest $request)
    {
        $insumo = Insumo::create($request->all());
        if ($insumo) {
            flash("Registro salvo com sucesso.", 'success');
        }

        return redirect()->route('insumo.index');
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
        $insumo = Insumo::find($id);

        return view('insumo.alterar', compact('insumo'));
    }

    /**
     * Altera os dados de um registro.
     *
     * @param int $id
     *
     * @param SalvarInsumoRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function atualizar($id, SalvarInsumoRequest $request)
    {
        $atualizado = Insumo::find($id)->update($request->all());
        if ($atualizado) {
            flash("Os dados do registro foram alterados com sucesso.", 'success');
        }

        return redirect()->route('insumo.index');
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
        $excluido = Insumo::find($id)->delete();

        if ($excluido) {
            flash("O registro foi excluído com sucesso.", 'success');
        }

        return redirect()->route('insumo.index');
    }

}
