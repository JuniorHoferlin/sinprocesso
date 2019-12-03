<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalvarFormularioRequest;
use App\Models\Formulario;
use App\Models\FormularioCampo;
use App\Models\TipoCampo;
use App\Relatorios\FormularioListagem;

class FormularioController extends Controller
{

    private $listagem;

    public function __construct(FormularioListagem $listagem)
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

        return view('formularios.index', compact('dados', 'filtros'));
    }

    /**
     * Exibe a tela para adicionar um novo registro.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adicionar()
    {
        return view('formularios.adicionar');
    }

    /**
     * Adiciona um novo registro.
     *
     * @param SalvarFormularioRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function salvar(SalvarFormularioRequest $request)
    {
        $formulario = Formulario::create($request->all());
        if ($formulario) {
            flash("Registro salvo com sucesso.", 'success');
        }

        return redirect()->route('formularios.alterar', [$formulario->id, 'campos']);
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
        $formulario = Formulario::with('campos.tipo')->find($id);
        $campos = $formulario->campos;
        $tipos = TipoCampo::orderBy('descricao', 'ASc')->get();

        return view('formularios.alterar', compact('formulario', 'aba', 'campos', 'tipos'));
    }

    /**
     * Altera os dados de um registro.
     *
     * @param int $id
     *
     * @param SalvarFormularioRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function atualizar($id, SalvarFormularioRequest $request)
    {
        $atualizado = Formulario::find($id)->update($request->all());
        if ($atualizado) {
            flash("Os dados do registro foram alterados com sucesso.", 'success');
        }

        return redirect()->route('formularios.index');
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
        $excluido = Formulario::find($id)->delete();
        if ($excluido) {
            flash("O registro foi excluído com sucesso.", 'success');
        }

        return redirect()->route('formularios.index');
    }

    /**
     * Adiciona um novo campo em um formulário.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adicionarCampo()
    {
        $campo = FormularioCampo::create(request()->all());
        $view = view('formularios.item_campo', compact('campo'))->render();

        return $view;
    }

    /**
     * Remove um campo do formulário.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function removerCampo()
    {
        $id = request('id');
        $excluido = FormularioCampo::find($id)->delete();

        return response()->json($excluido);
    }

    /**
     * Salva os dados de um campo.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function salvarCampo()
    {
        $id = request('id');
        $dados = request()->except('id');

        $atualizado = FormularioCampo::find($id)->update($dados);

        return response()->json($atualizado);
    }

}
