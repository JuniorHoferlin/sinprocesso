<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalvarChamadoTecnicoRequest;
use App\Models\ChamadoTecnico;
use App\Relatorios\ChamadoTecnicoListagem;

class ChamadoTecnicoController extends Controller
{

    private $listagem;

    public function __construct(ChamadoTecnicoListagem $listagem)
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
        return view('chamado_tecnico.index', compact('dados', 'filtros'));
    }

    /**
     * Exibe a tela para adicionar um novo registro.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adicionar()
    {
        return view('chamado_tecnico.adicionar');
    }

    /**
     * Adiciona um novo registro.
     *
     * @param SalvarChamadoTecnicoRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function salvar(SalvarChamadoTecnicoRequest $request)
    {
        $chamado_tecnico = ChamadoTecnico::create($request->all());
        $dados = $this->listagem->gerar([]);
        $view = view('chamado_tecnico.listagem', compact('dados'))->render();
        if ($chamado_tecnico) {
            return response()->json(['status' => 1, 'view' => $view]);
        }
        return response()->json(['status' => 0, 'view' => $view]);
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
        $chamado_tecnico = ChamadoTecnico::find($id);
        return view('chamado_tecnico.alterar', compact('chamado_tecnico'));
    }

    /**
     * Altera os dados de um registro.
     *
     * @param int $id
     *
     * @param SalvarChamadoTecnicoRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function atualizar($id, SalvarChamadoTecnicoRequest $request)
    {
        $atualizado = ChamadoTecnico::find($id)->update($request->all());
        if ($atualizado) {
            flash("Os dados do registro foram alterados com sucesso.", 'success');
        }
        return redirect()->route('suporte.index');
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
        $excluido = ChamadoTecnico::find($id)->delete();
        if ($excluido) {
            flash("O registro foi excluído com sucesso.", 'success');
        }
        return redirect()->route('suporte.index');
    }
}
