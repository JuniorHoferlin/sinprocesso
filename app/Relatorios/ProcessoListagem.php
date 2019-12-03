<?php

namespace App\Relatorios;

use App\Models\Processo;
use DB;

class ProcessoListagem extends RelatorioBase
{

    /**
     * Título do relatório.
     *
     * @var string
     */
    protected $titulo = 'Lista de Processos';

    /**
     * Quantidade de itens por página.
     *
     * @var int
     */
    protected $porPagina = 10;

    /**
     * A view utilizada para impressão deste relatório.
     *
     * @var string
     */
    protected $view = 'processos.imprimir';

    /**
     * Gera os dados.
     *
     * @param array $filtros
     * @param bool $paginar
     *
     * @return mixed
     */
    public function gerar($filtros, $paginar = true)
    {
        $processos = Processo::with(['tipo', 'tarefas.historico', 'area'])->orderBy('id', 'DESC');

        if (!empty($filtros['descricao'])) {
            $processos->where('descricao', 'LIKE', '%' . $filtros['descricao'] . '%');
        }

        if (!empty($filtros['numero_cipar'])) {
            $processos->where('numero_cipar', 'LIKE', '%' . $filtros['numero_cipar'] . '%');
        }

        if (!empty($filtros['id_area'])) {
            $processos->where('id_area', $filtros['id_area']);
        }

        if (!empty($filtros['status'])) {
            $processos->where('status', $filtros['status']);
        }

        if (!empty($filtros['id_modalidade'])) {
            $processos->where('id_modalidade', $filtros['id_modalidade']);
        }

        if (!empty($filtros['data_inicio'])) {
            $data = formatarData($filtros['data_inicio'], 'Y-m-d');
            $processos->whereRaw("DATE(data_inicio) = '$data'");
        }

        if (!empty($filtros['data_fim'])) {
            $data = formatarData($filtros['data_fim'], 'Y-m-d');
            $processos->whereRaw("DATE(data_fim) = '$data'");
        }

        if ($paginar) {
            return $processos->paginate($this->porPagina);
        }

        return $processos->get();
    }
}