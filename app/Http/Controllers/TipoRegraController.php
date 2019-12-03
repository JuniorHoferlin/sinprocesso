<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalvarTipoRegraRequest;
use App\Models\TipoRegra;
use App\Relatorios\TipoRegraListagem;

class TipoRegraController extends Controller
{

    private $listagem;

    public function __construct(TipoRegraListagem $listagem)
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

        return view('tipo_regra.index', compact('dados', 'filtros'));
    }

    /**
     * Exibe a tela para adicionar um novo registro.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adicionar()
    {
        return view('tipo_regra.adicionar');
    }

    /**
     * Adiciona um novo registro.
     *
     * @param SalvarFeriadoRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function salvar(SalvarTipoRegraRequest $request)
    {
        $tipoRegra = TipoRegra::create($request->all());
        if ($tipoRegra) {
            flash("Registro salvo com sucesso.", 'success');
        }

        return redirect()->route('tipo_regra.index');
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
        $tipo = TipoRegra::find($id);

        return view('tipo_regra.alterar', compact('tipo'));
    }

    /**
     * Altera os dados de um registro.
     *
     * @param int $id
     *
     * @param SalvarFeriadoRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function atualizar($id, SalvarTipoRegraRequest $request)
    {
        $atualizado = TipoRegra::find($id)->update($request->all());
        if ($atualizado) {
            flash("Os dados do registro foram alterados com sucesso.", 'success');
        }

        return redirect()->route('tipo_regra.index');
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
        $excluido = TipoRegra::find($id)->delete();

        if ($excluido) {
            flash("O registro foi excluído com sucesso.", 'success');
        }

        return redirect()->route('tipo_regra.index');
    }

}
