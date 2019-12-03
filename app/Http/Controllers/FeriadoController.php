<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalvarFeriadoRequest;
use App\Models\Feriado;
use App\Relatorios\FeriadoListagem;

class FeriadoController extends Controller
{

    /**
     * @var FeriadoListagem
     */
    private $listagem;

    public function __construct(FeriadoListagem $listagem)
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
        $tipos = Feriado::$tiposFeriados;

        return view('feriados.index', compact('dados', 'filtros', 'tipos'));
    }

    /**
     * Exibe a tela para adicionar um novo registro.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adicionar()
    {
        $tipos = Feriado::$tiposFeriados;

        return view('feriados.adicionar', compact('tipos'));
    }

    /**
     * Adiciona um novo registro.
     *
     * @param SalvarFeriadoRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function salvar(SalvarFeriadoRequest $request)
    {
        $feriado = Feriado::create($request->all());
        if ($feriado) {
            flash("Registro salvo com sucesso.", 'success');
        }

        return redirect()->route('feriados.index');
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
        $feriado = Feriado::find($id);
        $tipos = Feriado::$tiposFeriados;

        return view('feriados.alterar', compact('feriado', 'tipos'));
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
    public function atualizar($id, SalvarFeriadoRequest $request)
    {
        $atualizado = Feriado::find($id)->update($request->all());
        if ($atualizado) {
            flash("Os dados do registro foram alterados com sucesso.", 'success');
        }

        return redirect()->route('feriados.index');
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
        $excluido = Feriado::find($id)->delete();

        if ($excluido) {
            flash("O registro foi excluído com sucesso.", 'success');
        }

        return redirect()->route('feriados.index');
    }

}
