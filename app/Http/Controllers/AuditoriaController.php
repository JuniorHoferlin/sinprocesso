<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use App\Models\TipoRota;
use App\Models\Usuario;
use App\Relatorios\AuditoriaListagem;

class AuditoriaController extends Controller
{

    /**
     * @var AuditoriaListagem
     */
    private $listagem;

    public function __construct(AuditoriaListagem $listagem)
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
        $tipos = TipoRota::whereHas('rotas', function ($q) {
            $q->where('desenv', 'N');
        })->orderBy('descricao', 'ASC')->get();
        $usuarios = Usuario::orderBy('nome')->get();

        return view('auditoria.index', compact('dados', 'filtros', 'tipos', 'usuarios'));
    }

    /**
     * Visualizar detalhes de uma auditoria.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function visualizar($id)
    {
        $auditoria = Auditoria::with(['acoes', 'tipo', 'rota', 'usuario'])->find($id);

        return view('auditoria.visualizar', compact('auditoria'));
    }

}
