<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalvarGrupoAcessoRequest;
use App\Models\Area;
use App\Models\GrupoAcesso;
use App\Models\Rota;
use App\Relatorios\GrupoAcessoListagem;
use Illuminate\Support\Facades\Cache;

class GrupoAcessoController extends Controller
{

    private $listagem;

    public function __construct(GrupoAcessoListagem $listagem)
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

        return view('grupo_acesso.index', compact('dados', 'filtros'));
    }

    /**
     * Exibe a tela para adicionar um novo registro.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adicionar()
    {
        $areas = Area::listarAreasLeveis();

        return view('grupo_acesso.adicionar', compact('areas'));
    }

    /**
     * Adiciona um novo registro.
     *
     * @param SalvarGrupoAcessoRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function salvar(SalvarGrupoAcessoRequest $request)
    {
        $grupo = GrupoAcesso::create($request->except('areas'));
        if ($grupo) {
            $grupo->areas()->sync($request->get('areas'));
            flash("Registro salvo com sucesso.", 'success');
        }

        return redirect()->route('grupo_acesso.index');
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
        $grupo = GrupoAcesso::with('areas')->find($id);
        $areas = Area::listarAreasLeveis([], 0, $grupo->areas->pluck('id')->toArray());

        return view('grupo_acesso.alterar', compact('grupo', 'areas'));
    }

    /**
     * Altera os dados de um registro.
     *
     * @param int $id
     *
     * @param SalvarGrupoAcessoRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function atualizar($id, SalvarGrupoAcessoRequest $request)
    {
        $grupo = GrupoAcesso::find($id);
        $atualizado = $grupo->update($request->except('areas'));
        if ($atualizado) {
            $grupo->areas()->sync($request->get('areas'));
            flash("Os dados do registro foram alterados com sucesso.", 'success');
        }

        return redirect()->route('grupo_acesso.index');
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
        $excluido = GrupoAcesso::find($id)->delete();
        if ($excluido) {
            flash("O registro foi excluído com sucesso.", 'success');
        }

        return redirect()->route('grupo_acesso.index');
    }

    /**
     * Exibe a tela para gerenciar as permissões de todos os grupos de acesso do sistema.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function gerenciarPermissoes()
    {
        $grupos = GrupoAcesso::with('rotas')
                             ->where('super_admin', 'N')
                             ->orderBy('descricao', 'ASC')
                             ->get();

        $rotas = Rota::with('tipo')->where('acesso_liberado', 'N')->where('desenv', 'N')->get();
        $rotas = $rotas->groupBy('tipo.descricao')->sortBy(function ($items, $key) {
            return $key;
        });

        return view('grupo_acesso.gerenciar_permissoes', compact('grupos', 'rotas'));
    }

    /**
     * Salva as permissões gerenciadas para cada grupo.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function salvarPermissoes()
    {
        $grupo = GrupoAcesso::find(request('id_grupo_acesso'));
        $rotas = request('rotas');
        $grupo->rotas()->sync($rotas);
        Cache::forget('rotas');

        // Nao estou tratando erros, eu sei
        return response()->json(true);
    }

    /**
     * Carrega as permissoes de um grupo de acesso.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function carregarPermissoes()
    {
        $id = request('id');
        $grupo = GrupoAcesso::with('rotas')->find($id);

        return response()->json($grupo->rotas);
    }
}
