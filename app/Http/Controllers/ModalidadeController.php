<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalvarModalidadeRequest;
use App\Models\Modalidade;
use App\Relatorios\ModalidadeListagem;

class ModalidadeController extends Controller
{

    private $listagem;

    public function __construct(ModalidadeListagem $listagem)
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
        return view('modalidade.index', compact('dados', 'filtros'));
    }

    /**
     * Exibe a tela para adicionar um novo registro.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adicionar()
    {
        return view('modalidade.adicionar');
    }

    /**
     * Adiciona um novo registro.
     *
     * @param SalvarModalidadeRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function salvar(SalvarModalidadeRequest $request)
    {
        $modalidade = Modalidade::create($request->all());
        if ($modalidade) {
            flash("Registro salvo com sucesso.", 'success');
        }
        return redirect()->route('modalidade.index');
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
        $modalidade = Modalidade::find($id);
        return view('modalidade.alterar', compact('modalidade'));
    }

    /**
     * Altera os dados de um registro.
     *
     * @param int $id
     *
     * @param SalvarModalidadeRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function atualizar($id, SalvarModalidadeRequest $request)
    {
        $atualizado = Modalidade::find($id)->update($request->all());
        if ($atualizado) {
            flash("Os dados do registro foram alterados com sucesso.", 'success');
        }
        return redirect()->route('modalidade.index');
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
        $excluido = Modalidade::find($id)->delete();
        if ($excluido) {
            flash("O registro foi excluído com sucesso.", 'success');
        }
        return redirect()->route('modalidade.index');
    }
}
