<?php

namespace App\Http\Controllers\Relatorios;

use App\Http\Controllers\Controller;
use App\Models\HistoricoTarefa;
use App\Models\Processo;
use App\Models\Usuario;
use App\Relatorios\AndamentoTarefas;

class AndamentoTarefaController extends Controller
{

    /**
     * @var AndamentoTarefas
     */
    private $relatorio;

    public function __construct(AndamentoTarefas $relatorio)
    {
        $this->relatorio = $relatorio;
    }

    /**
     * Exibe a página inicial do relatório.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $filtros = request()->all();
        if (isset($filtros['acao']) && $filtros['acao'] == 'imprimir') {
            return $this->relatorio->exportar($filtros);
        }

        $dados = [];
        $pagina = request()->get('page', 1);
        if (isset($filtros['acao']) && $filtros['acao'] == 'filtrar') {
            $dados = $this->relatorio->gerar($filtros, true, $pagina);
        }

        $usuarios = Usuario::orderBy('nome', 'ASC')->get();
        $status_p = Processo::$status;
        $status_t = HistoricoTarefa::$status;

        return view('relatorios.andamento_tarefas.index', compact('dados', 'filtros', 'usuarios', 'status_t', 'status_p'));
    }
}