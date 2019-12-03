<?php

namespace App\Http\Controllers;

use App\Services\DashboardDados;

class HomeController extends Controller
{

    /**
     * @var DashboardDados
     */
    private $dashboardDados;

    public function __construct(DashboardDados $dashboardDados)
    {
        $this->dashboardDados = $dashboardDados;
    }

    /**
     * Exibe a página inicial do sistema.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Busca os dados para o dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function buscarDadosDashboard()
    {
        $dados = $this->dashboardDados->buscarDados(request('selecao'));

        return response()->json($dados);
    }
}
