<?php

namespace App\Http\Controllers\Relatorios;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Processo;
use App\Relatorios\InsumoProcesso;

class InsumoProcessoController extends Controller
{

    /**
     * @var AndamentoTarefas
     */
    private $relatorio;

    public function __construct(InsumoProcesso $relatorio)
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

        return view('relatorios.insumo_processo.index', compact('dados', 'filtros', 'status', 'areas'));
    }


    /**
     * Exibe os insumos do processo em questão
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ver($idProcesso)
    {

        $processo = Processo::with('insumos.tarefaInsumo', 'insumos.insumoTermo.insumo')->find($idProcesso);

        return view('relatorios.insumo_processo.ver', compact('processo'));
    }
}