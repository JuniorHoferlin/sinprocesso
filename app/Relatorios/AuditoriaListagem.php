<?php

namespace App\Relatorios;

use App\Models\Auditoria;

class AuditoriaListagem extends RelatorioBase
{

    /**
     * Título do relatório.
     *
     * @var string
     */
    protected $titulo = 'Auditoria';

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
    protected $view = 'auditoria.imprimir';

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
        $auditoria = Auditoria::with(['acoes', 'tipo', 'rota', 'usuario'])->orderBy('created_at', 'DESC');

        if (!empty($filtros['id_perm_tipo_rota'])) {
            $auditoria->where('id_perm_tipo_rota', $filtros['id_perm_tipo_rota']);
        }

        if (!empty($filtros['id_usuario'])) {
            $auditoria->where('id_usuario', $filtros['id_usuario']);
        }

        if (!empty($filtros['data'])) {
            $data = formatarData($filtros['data'], 'Y-m-d');
            $auditoria->whereRaw("DATE(created_at) = '$data'");
        }

        if ($paginar) {
            return $auditoria->paginate($this->porPagina);
        }

        return $auditoria->get();
    }
}