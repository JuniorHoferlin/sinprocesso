<?php

namespace App\Services;

use App\Models\Feriado;
use App\Models\Processo;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class CalculaDiasExecucao
{

    /**
     * Calcula para cada tarefa quantos dias em execução ela está/ficou.
     *
     * @param int $id ID do processo.
     * @param Collection $tarefas Lista de tarefas.
     *
     * @return Collection
     */
    public function diasExecucaoTarefas($id, $tarefas)
    {
        // Vamos pegar somente os feriados de um determinado periodo
        $processo = Processo::find($id);
        $feriados = $this->buscarFeriadosIntervalo($processo);

        $tarefas = $tarefas->map(function ($tarefa) use ($feriados) {
            $tarefa->dias_execucao = 0;

            $dataAberta = $tarefa->data_abertura;
            if (is_null($dataAberta)) {
                return $tarefa; // passa pra próxima tarefa
            }


            $dataFinalizado = Carbon::now();
            if (!is_null($tarefa->data_finalizado)) {
                $dataFinalizado = $tarefa->data_finalizado;
            }

            $diasExecucao = $dataAberta->diffInWeekdays($dataFinalizado);

            // Agora o mais importante: vamos considerar os feriados e remover da conta
            $diasDeFeriado = $this->retornaFeriadosDiasUteis($feriados);
            $tarefa->dias_execucao = $diasExecucao - $diasDeFeriado;

            return $tarefa;
        });

        return $tarefas;
    }

    /**
     * Baseado na data inicial/final do processo, busca os feriados existentes neste intervalo.
     *
     * @param Processo $processo
     *
     * @return mixed
     */
    private function buscarFeriadosIntervalo($processo)
    {
        $dataInicial = $processo->data_inicio;
        $dataFinal = Carbon::now();
        if (!is_null($processo->data_fim)) {
            $dataFinal = $processo->data_fim;
        }
        $feriados = Feriado::where('data', '>=', $dataInicial)->where('data', '<=', $dataFinal)->orderBy('data', 'ASC')->get();

        return $feriados;
    }

    /**
     * Retorna a quantidade de feriados que caem em dias úteis.
     *
     * @param Collection $feriados Lista de feriados a percorrer.
     *
     * @return int
     */
    private function retornaFeriadosDiasUteis($feriados)
    {
        return $feriados->filter(function ($feriado) {
            return $feriado->dia_semana;
        })->count();
    }

    /**
     * Retorna o total de dias que um processo está/ficou em execução.
     *
     * @param Processo $processo
     *
     * @return int
     */
    public function diasExecucaoProcesso($processo)
    {
        $feriados = $this->buscarFeriadosIntervalo($processo);

        $dataInicial = $processo->data_inicio;
        $dataFinal = Carbon::now();
        if (!is_null($processo->data_fim)) {
            $dataFinal = $processo->data_fim;
        }

        $diasExecucao = $dataFinal->diffInWeekdays($dataInicial);
        $diasDeFeriado = $this->retornaFeriadosDiasUteis($feriados);

        return $diasExecucao - $diasDeFeriado;
    }

}