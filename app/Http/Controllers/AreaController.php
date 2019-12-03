<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalvarAreaRequest;
use App\Models\Area;
use App\Relatorios\AreaListagem;

class AreaController extends Controller
{

    /**
     * @var AreaListagem
     */
    private $listagem;

    public function __construct(AreaListagem $listagem)
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

        return view('areas.index', compact('dados', 'filtros'));
    }

    /**
     * Exibe a tela para adicionar um novo registro.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adicionar()
    {
        $areas = Area::listarAreasLeveis();

        return view('areas.adicionar', compact('areas'));
    }

    /**
     * Adiciona um novo registro.
     *
     * @param SalvarAreaRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function salvar(SalvarAreaRequest $request)
    {
        $area = Area::create($request->all());
        if ($area) {
            flash("Registro salvo com sucesso.", 'success');
        }

        return redirect()->route('areas.index');
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
        $area = Area::find($id);
        $areas = Area::with('areas')->whereNull('id_area')->orderBy('descricao', 'ASC')->get();

        return view('areas.alterar', compact('area', 'areas'));
    }

    /**
     * Altera os dados de um registro.
     *
     * @param int $id
     *
     * @param SalvarAreaRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function atualizar($id, SalvarAreaRequest $request)
    {
        $atualizado = Area::find($id)->update($request->all());
        if ($atualizado) {
            flash("Os dados do registro foram alterados com sucesso.", 'success');
        }

        return redirect()->route('areas.index');
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
        $excluido = Area::find($id)->delete();

        if ($excluido) {
            flash("O registro foi excluído com sucesso.", 'success');
        }

        return redirect()->route('areas.index');
    }

}
