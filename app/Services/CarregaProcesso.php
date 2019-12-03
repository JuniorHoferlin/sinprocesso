<?php

namespace App\Services;

use App\Models\DocumentoPadrao;
use App\Models\Modalidade;
use App\Models\Processo;
use App\Models\TarefaProcesso;
use Gate;

class CarregaProcesso
{

    /**
     * @var CalculaDiasExecucao
     */
    private $calculaDiasExecucao;

    public function __construct(CalculaDiasExecucao $calculaDiasExecucao)
    {
        $this->calculaDiasExecucao = $calculaDiasExecucao;
    }

    /**
     * Carrega os dados necessários para visualizar os detalhes de um processo.
     *
     * @param int $id
     *
     * @return array
     */
    public function paraVisualizar($id)
    {
        $processo = Processo::with(
            [
                'tipo',
                'termoReferencia',
                'insumos.insumoTermo.insumo',
                'respostasFormulario.campo',
                'formulario.campos.tipo',
                'modalidade',
                'observacoes',
                'comentarios',
                'documentos',
                'anexos',
                'tarefas' => function ($q) {
                    $q->with(['dados', 'historico']);
                }
            ]
        )->find($id);
        $processo->dias_execucao = $this->calculaDiasExecucao->diasExecucaoProcesso($processo);

        $modalidades = Modalidade::orderBy('descricao', 'ASC')->get();
        $documentos = DocumentoPadrao::orderBy('titulo', 'ASC')->get();

        $tipo = $processo->tipo;
        $detalhesTarefas = $processo->detalhes_tarefas;
        $termo = $processo->termoReferencia;
        $insumos = $processo->insumos;
        $respostasFormulario = $processo->respostasFormulario;
        $formulario = $processo->formulario;
        $planoAcao = $processo->planoAcao;
        $observacoes = $processo->observacoes;
        $comentarios = $processo->comentarios;
        $anexos = $processo->anexos;
        $tarefas = $this->carregarTarefas($id);

        return [
            'processo'            => $processo,
            'modalidades'         => $modalidades,
            'documentos'          => $documentos,
            'tipo'                => $tipo,
            'detalhesTarefas'     => $detalhesTarefas,
            'termo'               => $termo,
            'respostasFormulario' => $respostasFormulario,
            'formulario'          => $formulario,
            'planoAcao'           => $planoAcao,
            'observacoes'         => $observacoes,
            'comentarios'         => $comentarios,
            'anexos'              => $anexos,
            'tarefas'             => $tarefas,
            'insumos'             => $insumos
        ];
    }

    /**
     * Carrega as tarefas do processo.
     *
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function carregarTarefas($id)
    {
        // Começamos com uma condição limpa, caso o usuário possa visualizar todas as tarefas, não vamos aplicar nada
        $condicao = function ($q) {
            $q->with('area');
        };

        // Verificamos se o usuário tem acesso a todas as tarefas, caso
        // ele tenha acesso, ele somente poderá VISUALIZAR, mas não pode fazer
        // nada nelas (iniciar, finalizar, etc) se ele não pertence ao grupo correto
        if (Gate::check('processos.visualizar_todas_tarefas') == false) {
            $condicao = function ($q) {
                $idGrupos = auth()->user()->gruposAcesso->pluck('id')->toArray();
                $q->with('area');
                $q->whereIn('id_grupo_acesso_area', $idGrupos);
            };
        }

        $tarefas = TarefaProcesso::with(
            [
                'historico',
                'dados' => $condicao,
                'tarefasFilhas.historico',
                'usuarioAbertura',
                'usuarioFechamento',
                'insumos'
            ]
        )->whereHas('dados', $condicao)->whereNull('id_tarefa_processo')
                                 ->where('id_processo', $id)->orderBy('ordem', 'ASC')->get();


        // Calcula os prazos de cada tarefa
        $tarefas = $this->calculaDiasExecucao->diasExecucaoTarefas($id, $tarefas);

        return $tarefas;
    }
}