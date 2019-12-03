<?php

namespace App\Services;

use App\Models\HistoricoTarefa;
use App\Models\TarefaProcesso;

class ReportaTarefa
{

    /**
     * Rotina para reportar uma tarefa.
     *
     * @param int $id
     * @param array $tarefas
     *
     * @return bool
     */
    public function reportar($id, $tarefas)
    {
        $data = date('Y-m-d H:i:s');
        $tarefa = TarefaProcesso::find($id);

        return $this->gerarNovasTarefas($data, $tarefa, $tarefas);
    }

    /**
     * Gera as novas tarefas apos o reporte.
     *
     * @param string $data
     * @param TarefaProcesso $tarefaOriginal
     *
     * @return bool
     */
    private function gerarNovasTarefas($data, $tarefaOriginal, $tarefas)
    {
        // Agora geramos as novas
        $ordem = 1;
        if (!empty($tarefas)) {
            foreach ($tarefas as $key => $t) {
                // Muda o status da tarefa escolhida para reportada
                $t = TarefaProcesso::find($t);
                $this->reportarTarefa($t->id);

                //Agora geramos uma nova tarefa, ligada a tarefa original
                $novaTarefa = TarefaProcesso::create(
                    [
                        'id_processo'        => $t->id_processo,
                        'id_tarefa'          => $t->id_tarefa,
                        'ordem'              => $ordem,
                        'id_tarefa_processo' => $tarefaOriginal->id
                    ]
                );

                HistoricoTarefa::create(
                    [
                        'id_tarefa_processo' => $novaTarefa->id,
                        'data'               => $data,
                        'situacao'           => 'ABERTO'
                    ]
                );
                $ordem++;
            }

            $novaTarefa = TarefaProcesso::create(
                [
                    'id_processo'        => $tarefaOriginal->id_processo,
                    'id_tarefa'          => $tarefaOriginal->id_tarefa,
                    'ordem'              => $ordem,
                    'id_tarefa_processo' => $tarefaOriginal->id
                ]
            );

            HistoricoTarefa::create(
                [
                    'id_tarefa_processo' => $novaTarefa->id,
                    'data'               => $data,
                    'situacao'           => 'ABERTO'
                ]
            );
        }

        return true;
    }

    /**
     * Reporta a tarefa especificada.
     *
     * @param int $id
     */
    private function reportarTarefa($id)
    {
        HistoricoTarefa::create(
            [
                'id_tarefa_processo' => $id,
                'data'               => date('Y-m-d H:i:s'),
                'situacao'           => 'REPORTADA'
            ]
        );
    }
}