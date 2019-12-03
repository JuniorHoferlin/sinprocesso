<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalvarRotaRequest;
use App\Models\Rota;
use App\Models\TipoRota;
use App\Relatorios\RotaListagem;

class RotaController extends Controller
{

    /**
     * @var RotaListagem
     */
    private $listagem;

    public function __construct(RotaListagem $listagem)
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
        $tipos = TipoRota::orderBy('descricao', 'ASC')->get();

        return view('rotas.index', compact('dados', 'filtros', 'tipos'));
    }

    /**
     * Exibe a tela para adicionar um novo registro.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adicionar()
    {
        $tipos = TipoRota::orderBy('descricao', 'ASC')->get();

        return view('rotas.adicionar', compact('tipos'));
    }

    /**
     * Adiciona um novo registro.
     *
     * @param SalvarRotaRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function salvar(SalvarRotaRequest $request)
    {
        $rota = Rota::create($request->all());
        if ($rota) {
            flash("Registro salvo com sucesso.", 'success');
        }

        return redirect()->route('rotas.index');
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
        $rota = Rota::find($id);
        $tipos = TipoRota::orderBy('descricao', 'ASC')->get();

        return view('rotas.alterar', compact('rota', 'tipos'));
    }

    /**
     * Altera os dados de um registro.
     *
     * @param int $id
     *
     * @param SalvarRotaRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function atualizar($id, SalvarRotaRequest $request)
    {
        $atualizado = Rota::find($id)->update($request->all());
        if ($atualizado) {
            flash("Os dados do registro foram alterados com sucesso.", 'success');
        }

        return redirect()->route('rotas.index');
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
        $excluido = Rota::find($id)->delete();

        if ($excluido) {
            flash("O registro foi excluído com sucesso.", 'success');
        }

        return redirect()->route('rotas.index');
    }

}
