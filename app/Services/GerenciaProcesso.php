<?php

namespace App\Services;

use App\Models\HistoricoTarefa;
use App\Models\Processo;
use App\Models\Tarefa;
use App\Models\TarefaProcesso;
use DB;
use Exception;
use Gate;

class GerenciaProcesso
{

    /**
     * @var ReportaTarefa
     */
    private $reportaTarefa;

    public function __construct(ReportaTarefa $reportaTarefa)
    {
        $this->reportaTarefa = $reportaTarefa;
    }

    /**
     * Reporta uma ou mais tarefas.
     *
     * @param int $id ID da tarefa original.
     * @param array $tarefas As tarefas que foram selecionadas para reporte.
     *
     * @return bool
     */
    public function reportarTarefa($id, $tarefas)
    {
        // Primeira coisa é finalizar a tarefa atual
        $this->finalizarTarefa($id, false);
        $retorno = $this->reportaTarefa->reportar($id, $tarefas);

        // Agora que ja temos as novas tarefas geradas pelo reporte vamos iniciar a proxima aberta automaticamente
        $tarefa = TarefaProcesso::find($id);
        $this->iniciarProximaTarefa($tarefa->id_processo);

        return $retorno;
    }

    /**
     * Finaliza a tarefa selecionada.
     *
     * @param int $id ID da tarefa a ser finalizada.
     * @param bool $iniciarProxima Indica se já é para iniciar a próxima tarefa.
     *
     * @return bool
     */
    public function finalizarTarefa($id, $iniciarProxima = true)
    {
        $return = false;

        $tarefa = DB::transaction(function () use ($id, &$retorno) {
            $tarefa = TarefaProcesso::find($id);

            $data = date('Y-m-d H:i:s');
            $tarefa->id_usuario_fechamento = auth()->user()->id;
            $tarefa->data_finalizado = $data;
            $tarefa->update();

            HistoricoTarefa::create(
                [
                    'id_tarefa_processo' => $tarefa->id,
                    'data'               => $data,
                    'situacao'           => 'CONCLUIDO',
                ]
            );

            return $tarefa;
        });

        if ($tarefa->dados->tipo == "COMPRA") {
            if ($this->verificarExistenciaInsumosPendentes($tarefa->id_processo)) {
                if ($this->abrirTarefaCompra($tarefa)) {
                    $return = true;
                }
            }

            // verifica se a tarefa compra estava em sala de situação
            if ($tarefa->sala_situacao == "S") {
                // busca a primeira tarefa de assinatura da lista que esteja aberta
                $tarefaAssinatura = TarefaProcesso::with('ultimoHistorico')
                                                  ->where('id_processo', $tarefa->id_processo)
                                                  ->whereHas('dados', function ($q) {
                                                      $q->where('tipo', 'ASSINATURA');
                                                  })->get()->filter(function ($tarefaProcesso) {
                        return $tarefaProcesso->ultimoHistorico->situacao == 'ABERTO';
                    })->sortBy('ordem')->first();

                if ($tarefaAssinatura) {
                    if ($this->iniciarTarefa($tarefaAssinatura->id)) {
                        $iniciarProxima = false;
                        $return = true;
                    }
                }
            }
        }

        if ($tarefa->dados->tipo == "ASSINATURA") {
            if ($this->verificarExistenciaCompraPendentes($tarefa->id_processo)) {
                if ($this->abrirTarefaAssinatura($tarefa)) {
                    $return = true;
                }
            }
        }

        // Vamos procurar pela proxima tarefa e já inicia-la caso haja alguma
        if (isset($tarefa->id_processo) && $iniciarProxima) {
            if ($this->iniciarProximaTarefa($tarefa->id_processo)) {
                $return = true;
            }
        }

        return $return;
    }

    /**
     * Verifica se existe insumos pendente de compra no processo
     *
     * @param Processo $id (id do processo a ser verificado)
     *
     * @return bool
     */
    function verificarExistenciaInsumosPendentes($id = false)
    {
        // carrega o processo dessa tarefa jutamente com os insumos do processo
        $processo = Processo::with('insumos')->find($id);
        $existeInsumoEmAberto = false;

        // percorre os insumos do processo
        $processo->insumos->each(function ($insumo) use (&$existeInsumoEmAberto) {

            $quantidadeComprada = 0;

            // quantidade que já foi comprada até o momento referente aqueles insumos daquele processo
            $insumo->tarefaInsumo->each(function ($tarefaInsumo) use (&$quantidadeComprada) {
                $quantidadeComprada = $quantidadeComprada + $tarefaInsumo->quantidade;
            });

            // quantidade que ja foi comprada menos a quantidade solicitada, teremos a quantidade pendente de compra
            $quantidadeAberto = $insumo->quantidade - $quantidadeComprada;

            // se a quantidade em aberto for maior que 0
            if ($quantidadeAberto > 0) {
                $existeInsumoEmAberto = true;
            }
        });

        return $existeInsumoEmAberto;
    }

    /**
     * Abre uma nova tarefa de compra
     *
     * @param TarefaProcesso $tarefa
     *
     * @return TarefaProcesso
     */
    function abrirTarefaCompra($tarefa)
    {
        // Retorno da função
        $retorno = false;

        // Inicio da transação
        DB::transaction(function () use ($tarefa, &$retorno) {
            // Cria a tarefa de compra
            $tarefa = TarefaProcesso::create(
                [
                    'id_tarefa_processo' => $tarefa->id,
                    'id_tarefa'          => $tarefa->id_tarefa,
                    'id_processo'        => $tarefa->id_processo,
                    'id_formulario'      => $tarefa->id_formulario,
                    'sala_situacao'      => 'N',
                    'ordem'              => 1,
                ]
            );

            // Gera o histórico da tarefa de compra
            HistoricoTarefa::create(
                [
                    'id_tarefa_processo' => $tarefa->id,
                    'data'               => date('Y-m-d H:i:s'),
                    'situacao'           => 'ABERTO',
                ]
            );

            $retorno = true;
        });

        return $retorno;
    }

    /**
     * Inicia uma tarefa de um processo.
     *
     * @param int $id ID da tarefa
     *
     * @return bool
     * @throws Exception
     */
    public function iniciarTarefa($id)
    {
        $tarefa = TarefaProcesso::with('dados.dependencias')->find($id);
        $permiteInicioManual = Gate::check('processos.iniciar_qualquer_tarefa');

        if (!$permiteInicioManual) {
            $podeIniciar = $this->verificaSePodeIniciar($tarefa);
            if (!$podeIniciar) {
                $dependencias = $tarefa->dados->dependencias->pluck('identificador')->map(function ($identificador) {
                    return 'T' . $identificador;
                })->implode('');
                throw new Exception("Não foi possível iniciar esta tarefa, ela depende que a(s) tarefa(s) ($dependencias) do processo estejam finalizadas.");
            }
        }

        $data = date('Y-m-d H:i:s');
        $tarefa->id_usuario_abertura = auth()->user()->id;
        $tarefa->data_abertura = $data;
        $tarefa->update();

        HistoricoTarefa::create(
            [
                'id_tarefa_processo' => $tarefa->id,
                'data'               => $data,
                'situacao'           => 'PENDENTE',
            ]
        );

        return true;
    }

    /**
     * Verifica se a tarefa que vai ser iniciada tem alguma dependencia em outra tarefa.
     *
     * @param TarefaProcesso $tarefa
     *
     * @return bool
     */
    private function verificaSePodeIniciar($tarefa)
    {
        if (count($tarefa->dados->dependencias) == 0) {
            return true;
        }

        // Vamos verificar se a tarefa que está sendo aberta possui alguma
        // dependencia em outra tarefa, isso é, essa tarefa depende que outras
        // tarefas tenham sido finalizadas primeiro para que esta possa ser iniciada.
        $ids = $tarefa->dados->dependencias->pluck('id')->toArray();
        $tarefasDoProcesso = TarefaProcesso::where('id_processo', $tarefa->id_processo)->whereIn('id_tarefa', $ids)->whereHas('ultimoHistorico', function ($q) {
            $q->whereIn('situacao', ['CONCLUIDO']);
        })->get();

        // Se o número de tarefas concluidas achadas é o mesmo numero das dependencias dessa tarefa, pode iniciar
        if (count($tarefasDoProcesso) == count($tarefa->dados->dependencias)) {
            return true;
        }

        return false;
    }

    /**
     * Verifica existencia de tarefa compra aberta/pendente no processo
     *
     * @param Processo $id (id do processo a ser verificado)
     *
     * @return bool
     */
    function verificarExistenciaCompraPendentes($id)
    {
        return TarefaProcesso::with('ultimoHistorico')->whereHas('dados', function ($q) {
                $q->where('tipo', 'COMPRA');
            })->where('id_processo', $id)->get()
                             ->filter(function ($tarefaProcesso) {
                                 return in_array($tarefaProcesso->ultimoHistorico->situacao, ['ABERTO', 'PENDENTE']);
                             })->count() > 0;
    }

    /**
     * Abre uma nova tarefa de assinatura
     *
     * @param TarefaProcesso $tarefa
     *
     * @return TarefaProcesso
     */
    function abrirTarefaAssinatura($tarefa)
    {
        // Retorno da função
        $retorno = false;

        // Inicio da transação
        DB::transaction(function () use ($tarefa, &$retorno) {
            // Cria a tarefa de compra
            $tarefa = TarefaProcesso::create(
                [
                    'id_tarefa_processo' => $tarefa->id,
                    'id_tarefa'          => $tarefa->id_tarefa,
                    'id_processo'        => $tarefa->id_processo,
                    'id_formulario'      => $tarefa->id_formulario,
                    'sala_situacao'      => 'N',
                    'ordem'              => 1,
                ]
            );

            // Gera o histórico da tarefa de compra
            HistoricoTarefa::create(
                [
                    'id_tarefa_processo' => $tarefa->id,
                    'data'               => date('Y-m-d H:i:s'),
                    'situacao'           => 'ABERTO',
                ]
            );

            $retorno = true;
        });

        return $retorno;
    }

    /**
     * Inicia a próxima tarefa que está aberta do processo (caso ela exista).
     *
     * @param int $idProcesso
     *
     * @return int
     */
    private function iniciarProximaTarefa($idProcesso)
    {
        $tarefaExecutando = TarefaProcesso::with('ultimoHistorico', 'dados')->where('id_processo', $idProcesso)->get()
                                          ->filter(function ($tarefaProcesso) {
                                              return $tarefaProcesso->ultimoHistorico->situacao == "PENDENTE";
                                          })
                                          ->first();

        // caso exista uma tarefa qualquer sendo executada, não abriremos uma outra tarefa automáticamente
        if (!$tarefaExecutando) {
            // caso nao exista nenhuma tarefa em andamento/aberta, finalizaremos o processo
            $tarefasAbertasAndamento = $this->buscarTarefasAbertasAndamento($idProcesso);
            if (count($tarefasAbertasAndamento) == 0) {
                Processo::find($idProcesso)->finalizar();

                return true;
            }

            // Agora queremos a primeira tarefa em aberto, para inicia-la
            $tarefaAberta = $tarefasAbertasAndamento->filter(function ($tarefa) {
                return $tarefa->ultimoHistorico->situacao == 'ABERTO';
            })->first();
            if ($tarefaAberta) {
                $this->iniciarTarefa($tarefaAberta->id);
            }

            return $tarefaAberta;
        } else {
            return $tarefaExecutando;
        }
    }

    /**
     * Busca todas as tarefas abertas e/ou em andamento de um processo.
     *
     * @param int $idProcesso
     *
     * @return mixed
     */
    private function buscarTarefasAbertasAndamento($idProcesso)
    {
        $tarefas = TarefaProcesso::with('ultimoHistorico')->where('id_processo', $idProcesso)->get()
                                 ->filter(function ($tarefaProcesso) {
                                     return in_array($tarefaProcesso->ultimoHistorico->situacao, ['ABERTO', 'PENDENTE']);
                                 })
                                 ->sortBy(function ($tarefaProcesso) {
                                     // cria uma nova ordenação para não dar problema nos subitens,
                                     // pois os subitens começam com ordem 1 denovo e eles estão sendo iniciados antes do previsto
                                     return $tarefaProcesso->ordem . $tarefaProcesso->id;
                                 });

        return $tarefas;
    }

    /**
     * Marca a tarefa de compra do processo como em sala de situação.
     *
     * @param int $id
     *
     * @return bool
     */
    public function enviarSalaSituacao($id)
    {
        $tarefa = TarefaProcesso::with('ultimoHistorico')->where('id_processo', $id)->whereHas('dados', function ($q) {
            $q->where('tipo', 'COMPRA');
        })->get()->filter(function ($tarefaProcesso) {
            return in_array($tarefaProcesso->ultimoHistorico->situacao, ['ABERTO', 'PENDENTE']);
        })->sortBy('ordem')->first();

        // Se existir mesmo a tarefa, marcamos ela como sala de situação e já iniciamos ela
        if ($tarefa) {
            $this->iniciarTarefa($tarefa->id);
            $tarefa->sala_situacao = 'S';
            $tarefa->update();
        }

        return true;
    }

    /**
     * Adiciona uma tarefa que será exclusiva deste processo.
     *
     * @param array $dados
     *
     * @return bool
     */
    public function adicionarTarefa($dados)
    {
        $idProcesso = $dados['id_processo'];
        $idTarefaRelacionada = $dados['id_tarefa_processo'];
        $tarefaRelacionada = TarefaProcesso::with('tarefasFilhas')->find($idTarefaRelacionada);
        $posicao = $dados['posicao'];
        $iniciar = $dados['iniciar'];
        unset($dados['id_processo'], $dados['id_tarefa_processo'], $dados['posicao'], $dados['iniciar']);

        switch ($posicao) {
            case 'DEPOIS':
                // Temos que verificar se a tarefa selecionada pelo usuário já esta dentro de outra
                // se tiver, essa nova tarefa estará dentro dela também
                if (!is_null($tarefaRelacionada->id_tarefa_processo)) {
                    $idTarefaRelacionada = $tarefaRelacionada->id_tarefa_processo;
                } else {
                    $idTarefaRelacionada = null;
                }

                $ordem = $tarefaRelacionada->ordem;

                // Agora vamos ordernar as tarefas com a nova ordem
                $query = TarefaProcesso::where('id_processo', $idProcesso)->where('id', '>', $tarefaRelacionada->id);
                if (is_null($idTarefaRelacionada)) {
                    $query->whereNull('id_tarefa_processo');
                } else {
                    $query->where('id_tarefa_processo', $idTarefaRelacionada);
                }

                $query->increment('ordem');
                break;
            case 'DENTRO':
                $ordem = $tarefaRelacionada->tarefasFilhas()->max('ordem');
                break;
        }

        $dados['exclusiva'] = 'S';
        $dados['tipo'] = 'PADRÃO';
        $tarefa = Tarefa::create($dados);
        if (!$tarefa) {
            return false;
        }

        $criada = $this->associarTarefa($tarefa, $idProcesso, ($ordem + 1), $idTarefaRelacionada);
        if ($criada && $iniciar == 'S') {
            $this->iniciarTarefa($criada->id);
        }

        return $criada;
    }

    /**
     * Associa uma tarefa ao processo.
     *
     * @param Tarefa $tarefa
     * @param int $idProcesso
     * @param int $ordem
     * @param null $idTarefaRelacionada
     *
     * @return mixed
     */
    public function associarTarefa($tarefa, $idProcesso, $ordem, $idTarefaRelacionada = null)
    {
        $tarefaProcesso = TarefaProcesso::create(
            [
                'id_processo'        => $idProcesso,
                'id_tarefa'          => $tarefa->id,
                'ordem'              => $ordem,
                'id_tarefa_processo' => $idTarefaRelacionada,
            ]
        );

        HistoricoTarefa::create(
            [
                'id_tarefa_processo' => $tarefaProcesso->id,
                'data'               => date('Y-m-d H:i:s'),
                'situacao'           => 'ABERTO',
            ]
        );

        return $tarefaProcesso;
    }
}