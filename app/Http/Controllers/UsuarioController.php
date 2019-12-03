<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalvarUsuarioRequest;
use App\Models\Cidade;
use App\Models\Estado;
use App\Models\Funcao;
use App\Models\GrupoAcesso;
use App\Models\Usuario;
use App\Relatorios\UsuarioListagem;

class UsuarioController extends Controller
{

    private $listagem;

    public function __construct(UsuarioListagem $listagem)
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

        return view('usuarios.index', compact('dados', 'filtros'));
    }

    /**
     * Exibe a tela para adicionar um novo registro.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adicionar()
    {
        $estados = Estado::orderBy('descricao', 'ASc')->get();
        $funcaoAreas = Funcao::listaFuncoesAreas();

        $superAdmin = auth()->user()->super_admin;
        $gruposAcesso = GrupoAcesso::listarGruposAreas($superAdmin);

        return view('usuarios.adicionar', compact('estados', 'funcaoAreas', 'gruposAcesso'));
    }

    /**
     * Adiciona um novo registro.
     *
     * @param SalvarUsuarioRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function salvar(SalvarUsuarioRequest $request)
    {
        $usuario = Usuario::create($request->except('grupos'));
        if ($usuario) {
            $usuario->gruposAcesso()->sync($request->get('grupos'));
            flash("Registro salvo com sucesso.", 'success');
        }

        return redirect()->route('usuarios.index');
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
        $usuario = Usuario::with('cidade.estado', 'gruposAcesso')->find($id);
        $estados = Estado::orderBy('descricao', 'ASC')->get();
        if (!empty($usuario->id_cidade)) {
            $cidades = Cidade::where('id_estado', $usuario->cidade->id_estado)->orderBy('descricao', 'ASC')->get();
        }

        $funcaoAreas = Funcao::listaFuncoesAreas();

        $superAdmin = auth()->user()->super_admin;
        $gruposAcesso = GrupoAcesso::listarGruposAreas($superAdmin);

        return view('usuarios.alterar', compact('usuario', 'estados', 'funcaoAreas', 'cidades', 'gruposAcesso'));
    }

    /**
     * Altera os dados de um registro.
     *
     * @param int $id
     *
     * @param SalvarUsuarioRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function atualizar($id, SalvarUsuarioRequest $request)
    {
        $usuario = Usuario::find($id);
        $atualizado = $usuario->update($request->except('grupos'));
        if ($atualizado) {
            $usuario->gruposAcesso()->sync($request->get('grupos'));
            flash("Os dados do registro foram alterados com sucesso.", 'success');
        }

        return redirect()->route('usuarios.index');
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
        $excluido = Usuario::find($id)->delete();
        if ($excluido) {
            flash("O registro foi excluído com sucesso.", 'success');
        }

        return redirect()->route('usuarios.index');
    }

    /**
     * Carrega as cidades do estado selecionado.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function carregarCidades()
    {
        $id = request()->get('id');
        $cidades = Cidade::where('id_estado', $id)->orderBy('descricao', 'ASC')->get();

        return response()->json($cidades);
    }

    /**
     * Altera o status do usuário no sistema.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function alterarStatus($id)
    {
        $usuario = Usuario::find($id);
        $usuario->status = $usuario->status == 'Ativo' ? 'Inativo' : 'Ativo';
        $usuario->update();

        flash('Registro atualizado com sucesso.', 'success');

        return redirect()->back();
    }

    /**
     * Exibe a tela "Minhas Tarefas".
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function minhasTarefas()
    {
        $dados = Usuario::buscarProcessosDoUsuario();

        return view('usuarios.minhas_tarefas', compact('processos', 'dados'));
    }

}
