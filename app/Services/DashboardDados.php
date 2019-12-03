<?php

namespace App\Services;

use App\Models\Insumo;
use App\Models\Processo;
use App\Models\Tarefa;
use Carbon\Carbon;

class DashboardDados
{

    protected $datas = [];

    /**
     * Busca os dados para o dashboard.
     *
     * @param string $periodo
     *
     * @return array
     */
    public function buscarDados($periodo = 'dia')
    {
        $agora = Carbon::createFromFormat('Y-m-d', date('Y-m-d'), config('app.timezone'));

        $formatos = [
            'inicio' => 'Y-m-d 00:00:00',
            'fim'    => 'Y-m-d 23:59:59'
        ];

        switch ($periodo) {
            case 'dia':
                $this->datas = [
                    'inicio' => $agora,
                    'fim'    => $agora
                ];
                break;
            case 'semana':
                $this->datas = [
                    'inicio' => $agora->startOfWeek()->toDateString(),
                    'fim'    => $agora->endOfWeek()->toDateString()
                ];
                break;
            case 'mes':
                $this->datas = [
                    'inicio' => $agora->firstOfMonth()->toDateString(),
                    'fim'    => $agora->lastOfMonth()->toDateString()
                ];
                break;
            case is_array($periodo):
                $this->datas = [
                    'inicio' => $periodo['inicio'],
                    'fim'    => $periodo['fim']
                ];
                break;
        }

        // Formata as datas para o formato certo
        array_walk($this->datas, function (&$data, $key) use ($formatos) {
            $data = formatarData($data, $formatos[$key]);
        });

        $retorno = [];
        $retorno['processos'] = $this->buscarProcessosPorStatus();
        $retorno['insumos_tramite'] = Insumo::buscarInsumosEmTramite($this->datas);
        $retorno['tempo_medio_tarefas'] = Tarefa::calcularTempoMedio($this->datas);
        $retorno['tipos_de_compra'] = collect(Processo::buscarTiposCompras($this->datas));
        $retorno['tipos_de_compra'] = json_encode($retorno['tipos_de_compra']->map(function ($item) {
            $novoItem = [
                'y' => $item->descricao,
                'a' => $item->quantidade
            ];

            return $novoItem;
        }));

        $retorno['datas'] = [
            'inicio' => formatarData($this->datas['inicio']),
            'fim'    => formatarData($this->datas['fim'])
        ];

        return $retorno;
    }

    /**
     * Retorna a quantidade de processos pelo seu status.
     */
    private function buscarProcessosPorStatus()
    {
        $processos = Processo::with('tarefas.historico')->where('data_inicio', '>=', $this->datas['inicio'])->where(function ($query) {
            $query->orWhere('data_fim', '<=', $this->datas['fim'])->orWhereNull('data_fim');
        })->get();

        $retorno = [
            'TOTAL'       => 0,
            'BLOQUEADO'    => 0,
            'FINALIZADO'   => 0,
            'EM_ANDAMENTO' => 0
        ];

        $processos->each(function ($processo) use (&$retorno) {
            switch ($processo->status) {
                case Processo::$status['ABERTO']:
                    $status = 'EM_ANDAMENTO';
                    break;
                case Processo::$status['BLOQUEADO']:
                case Processo::$status['FINALIZADO']:
                    $status = $processo->status;
                    break;
            }


            if (!isset($retorno[$status])) {
                $retorno[$status] = 0;
            }

            $retorno[$status] += 1;
            $retorno['TOTAL'] += 1;
        });

        return $retorno;
    }
}