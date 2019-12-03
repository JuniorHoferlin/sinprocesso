<?php

namespace App\Services;

use App\Models\Insumo;
use App\Models\PlanoAcao;
use App\Models\Processo;
use App\Models\ProcessoInsumoTermoReferencia;
use App\Models\ProcessoRespostaFormulario;
use App\Models\SituacaoRegra;
use App\Models\TermoReferencia;
use App\Models\TipoProcesso;
use DB;
use Exception;

class CriaProcesso
{

    /**
     * @var GerenciaProcesso
     */
    private $gerenciaProcesso;

    public function __construct(GerenciaProcesso $gerenciaProcesso)
    {
        $this->gerenciaProcesso = $gerenciaProcesso;
    }

    /**
     * Rotina para criar um novo processo.
     *
     * @param array $dados
     *
     * @return mixed
     */
    public function criar($dados)
    {
        $tipoProcesso = TipoProcesso::with('regras', 'formulario.campos')->find($dados['id_tipo_processo']);
        if ($tipoProcesso->tr == 'S') {
            try {
                // Verifica se existe o termo de ferencia com o codigo informado
                $termo = TermoReferencia::where('codigo', $dados['tr'])->first();
                $insumosExistentes = Insumo::verificarInsumosAbertos($termo->id);
                if (count($insumosExistentes) == 0) {
                    throw new Exception('Desculpe, mas todos os insumos desse termo de referência já foram abertos.');
                }
            }
            catch (Exception $e) {
                flash($e->getMessage(), 'danger');

                return false;
            }
        }

        $processo = $dados['processo'];
        $processo['status'] = Processo::$status['ABERTO'];

        // Vamos verificar agora se alguma das regras do processo está "incorreta", caso esteja, o processo é bloqueado
        if (isset($dados['regras'])) {
            foreach ($dados['regras'] as $regra) {
                if ($regra['situacao'] == 0) {
                    $processo['status'] = Processo::$status['BLOQUEADO'];
                    $processo['data_fim'] = date('Y-m-d H:i:s');
                }
            }
        }

        if ($tipoProcesso->tr == 'S') {
            $processo['id_termo_referencia'] = $termo->id;
        }

        $processo['id_area'] = $this->descobrirAreaProcesso();
        $processo['id_formulario'] = $tipoProcesso->id_formulario;
        $processo['id_tipo_processo'] = $tipoProcesso->id;
        $processo['data_inicio'] = date('Y-m-d H:i:s');

        // Agora salvamos o processo
        $processo = Processo::create($processo);

        if (!empty($dados['formulario'])) {
            $this->salvarRespostasFormulario($dados['formulario'], $processo->id, $tipoProcesso->id_formulario);
        }

        if (!empty($dados['regras'])) {
            $this->salvarRegras($dados['regras'], $processo->id);
        }


        if (!empty($dados['insumo'])) {
            $this->salvarDadosInsumo($dados['insumo'], $processo->id);
        }

        if ($processo->status == Processo::$status['ABERTO']) {
            $this->salvarTarefas($tipoProcesso, $processo->id);
        }

        // Cria o plano de ação
        PlanoAcao::create(['id_processo' => $processo->id]);

        return $processo;
    }

    /**
     * Descobre a area para qual este processo será associado.
     *
     * @return int
     */
    private function descobrirAreaProcesso()
    {
        $idFuncaoArea = auth()->user()->id_funcao_area;
        $funcaoArea = DB::table('funcao_area')->select('id_area')->where('id', $idFuncaoArea)->first();

        return $funcaoArea->id_area;
    }

    /**
     * Salva as respostas do formulário ao criar um novo processo.
     *
     * @param array $formulario
     * @param int $idProcesso
     * @param int $idFormulario
     */
    private function salvarRespostasFormulario($formulario, $idProcesso, $idFormulario)
    {
        foreach ($formulario as $id => $resposta) {
            ProcessoRespostaFormulario::create(
                [
                    'id_processo'         => $idProcesso,
                    'id_formulario'       => $idFormulario,
                    'id_formulario_campo' => $id,
                    'resposta'            => is_array($resposta) ? json_encode($resposta) : $resposta
                ]
            );
        }
    }

    /**
     * Salva o conteudo das regras ao abrir um novo processo.
     *
     * @param array $regras
     * @param int $idProcesso
     */
    private function salvarRegras($regras, $idProcesso)
    {
        foreach ($regras as $id => $valor) {
            SituacaoRegra::create(
                [
                    'id_processo'       => $idProcesso,
                    'id_regra_processo' => $id,
                    'situacao'          => $valor['situacao'],
                    'descricao'         => $valor['descricao']
                ]
            );
        }
    }

    /**
     * Salva os dados dos insumos ao abrir um novo processo.
     *
     * @param array $insumos
     * @param int $idProcesso
     */
    private function salvarDadosInsumo($insumos, $idProcesso)
    {
        foreach ($insumos as $id => $valor) {
            ProcessoInsumoTermoReferencia::create(
                [
                    'id_processo'                => $idProcesso,
                    'id_insumo_termo_referencia' => $valor['id'],
                    'quantidade'                 => $valor['qtd']
                ]
            );
        }
    }

    /**
     * Liga as tarefas do tipo de processo ao processo sendo aberto.
     *
     * @param TipoProcesso $tipoProcesso
     * @param int $idProcesso
     */
    private function salvarTarefas($tipoProcesso, $idProcesso)
    {
        $tarefas = [];
        foreach ($tipoProcesso->tarefas as $tarefa) {
            $tarefaProcesso = $this->gerenciaProcesso->associarTarefa($tarefa, $idProcesso, $tarefa->pivot->ordem);
            $tarefas[] = $tarefaProcesso;
        }

        // Depois de todas as tarefas criadas, vamos já marcar como iniciada a primeira tarefa
        if (count($tarefas)) {
            $this->gerenciaProcesso->iniciarTarefa($tarefas[0]->id);
        }
    }
}