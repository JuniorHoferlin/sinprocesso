<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalvarTipoRotaRequest;
use App\Models\TipoRota;
use App\Relatorios\TipoRotaListagem;

class TipoRotaController extends Controller
{

    /**
     * @var TipoRotaListagem
     */
    private $listagem;

    public function __construct(TipoRotaListagem $listagem)
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

        return view('tipos_rotas.index', compact('dados', 'filtros'));
    }

    /**
     * Exibe a tela para adicionar um novo registro.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adicionar()
    {
        return view('tipos_rotas.adicionar');
    }

    /**
     * Adiciona um novo registro.
     *
     * @param SalvarTipoRotaRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function salvar(SalvarTipoRotaRequest $request)
    {
        $tipo = TipoRota::create($request->all());
        if ($tipo) {
            flash("Registro salvo com sucesso.", 'success');
        }

        return redirect()->route('tipos_rotas.index');
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
        $tipo = TipoRota::find($id);

        return view('tipos_rotas.alterar', compact('tipo'));
    }

    /**
     * Altera os dados de um registro.
     *
     * @param int $id
     *
     * @param SalvarTipoRotaRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function atualizar($id, SalvarTipoRotaRequest $request)
    {
        $atualizado = TipoRota::find($id)->update($request->all());
        if ($atualizado) {
            flash("Os dados do registro foram alterados com sucesso.", 'success');
        }

        return redirect()->route('tipos_rotas.index');
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
        $excluido = TipoRota::find($id)->delete();

        if ($excluido) {
            flash("O registro foi excluído com sucesso.", 'success');
        }

        return redirect()->route('tipos_rotas.index');
    }

}
