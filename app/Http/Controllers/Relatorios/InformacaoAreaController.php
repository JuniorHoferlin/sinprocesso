<?php

namespace App\Http\Controllers\Relatorios;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Processo;
use App\Relatorios\InformacaoArea;

class InformacaoAreaController extends Controller
{

    /**
     * @var AndamentoTarefas
     */
    private $relatorio;

    public function __construct(InformacaoArea $relatorio)
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

        $status = Processo::$status;
        $areas = Area::listarAreasLeveis([], 0, [request('area')]);

        return view('relatorios.informacao_area.index', compact('dados', 'filtros', 'status', 'areas'));
    }
}