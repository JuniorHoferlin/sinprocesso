<?php

namespace App\Models;

use Carbon\Carbon;
use DB;
use Gate;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TarefaProcesso extends BaseModel
{

    protected $table = 'tarefa_processo';

    protected $dates = [
        'data_abertura',
        'data_finalizado',
    ];

    /**
     * Carrega as tarefas compativeis para efetuar a compra.
     *
     * @param TarefaProcesso $tarefa
     *
     * @return array|bool
     */
    public static function carregarInsumosParaComprar($tarefa)
    {
        // carrega o processo dessa tarefa jutamente com os insumos do processo
        $processo = Processo::with('insumos')->find($tarefa->id_processo);
        $insumosDisponiveis = [];

        // percorre os insumos do processo
        $processo->insumos->each(function ($insumo) use (&$insumosDisponiveis) {

            $quantidadeComprada = 0;

            // quantidade que já foi comprada até o momento referente aqueles insumos daquele processo
            $insumo->tarefaInsumo->each(function ($tarefaInsumo) use (&$quantidadeComprada) {
                $quantidadeComprada = $quantidadeComprada + $tarefaInsumo->quantidade;
            });

            // quantidade que ja foi comprada menos a quantidade solicitada, teremos a quantidade disponivel para compra
            $quantidadeDisponivel = $insumo->quantidade - $quantidadeComprada;

            // se a quantidade disponivel para compra for maior que 0
            // liberamos o insumo para compra (ps: limitando no client-side o maximo permitido para a compra)
            if ($quantidadeDisponivel > 0) {
                $insumosDisponiveis[] = [
                    'id'         => $insumo->id,
                    'quantidade' => $quantidadeDisponivel,
                    'produto'    => $insumo->insumoTermo->insumo->produto,
                ];
            }
        });

        // retorna os insumos disponiveis
        return $insumosDisponiveis;
    }

    /**
     * Carrega as tarefas possiveis para realizar o reporte.
     *
     * @param TarefaProcesso $tarefa
     *
     * @return array|bool
     */
    public static function carregarParaReportar($tarefa)
    {
        $id = $tarefa->id;
        $idProcesso = $tarefa->id_processo;
        $idTarefaProcesso = $tarefa->id_tarefa_processo;

        $query = "SELECT 
                    t.identificador, 
                    t.titulo, 
                    tp.id 
                  FROM tarefa_processo tp 
                  LEFT JOIN tarefa t on t.id = tp.id_tarefa 
                  WHERE tp.id != '$id' AND 
                  tp.id_processo = '$idProcesso'
        ";

        if (empty($idTarefaProcesso)) {
            $query .= " AND tp.id_tarefa_processo is null";
        } else {
            $query .= " AND tp.id_tarefa_processo = '$idTarefaProcesso'";
        }

        $tarefas = DB::select($query);
        $tarefasAceitas = [];
        $existeTarefa = false;

        foreach ($tarefas as $key => $outraTarefa) {
            $status = HistoricoTarefa::where('id_tarefa_processo', $outraTarefa->id)->orderBy('data', 'DESC')->take(1)->first();

            if ($status->situacao == "CONCLUIDO") {
                $subTarefa = TarefaProcesso::where('id_tarefa_processo', $outraTarefa->id)->first();
                if (is_null($subTarefa)) {
                    $tarefasAceitas[] = $outraTarefa;
                    $existeTarefa = true;
                }
            }
        }

        if (!$existeTarefa) {
            return false;
        }

        return $tarefasAceitas;
    }

    /**
     * Retorna se a tarefa esta atrasada em relação ao seu prazo de execução.
     *
     * @return string
     */
    public function getSituacaoPrazoAttribute()
    {
        $diasEmAberto = $this->dias_execucao;
        $prazoDias = $this->dados->prazo_dias;
        if ($diasEmAberto > $prazoDias) {
            return 'Atrasada';
        }

        return 'No Prazo';
    }

    /**
     * Retorna se a tarefa foi aberta.
     *
     * @return bool
     */
    public function getAbertaAttribute()
    {
        return $this->attributes['data_abertura'] ? true : false;
    }

    /**
     * Retorna a duração atual da tarefa em segundos.
     *
     * @return int
     */
    public function getDuracaoAttribute()
    {
        if ($this->ultimoHistorico->situacao != "ABERTO") {
            $end = $this->data_finalizado ? $this->data_finalizado : Carbon::now();

            return $this->data_abertura->diffInSeconds($end);
        } else {
            return 0;
        }
    }

    /**
     * Retorna se a tarefa foi fechada.
     *
     * @return bool
     */
    public function getFechadaAttribute()
    {
        return $this->attributes['data_finalizado'] ? true : false;
    }

    /**
     * Retorna o status da tarefa.
     */
    public function getStatusAttribute()
    {
        $historico = $this->historico->first();

        return $historico->situacao;
    }

    /**
     * Basedo no ultimo historico dessa tarefa, retorna o texto do status.
     *
     * @return string
     */
    public function getStatusArrayAttribute()
    {
        // Vamos garantir aqui que o usuário logado tem como grupo de acesso/area o mesmo
        // grupo acesso/area que foi especificado nos dados da tarefa caso contrário ele não poderá
        // realizar nenhuma ação na tarefa, ele poderá apenas visualizar caso possa visualizar todas as tarefas.
        // Lembrando que para iniciar tarefas manualmente somente se o usuário tiver permissão
        $podeIniciar = Gate::check('processos.iniciar_qualquer_tarefa');

        $liberado = false;
        $idGrupos = auth()->user()->gruposAcesso->pluck('id')->toArray();
        if (in_array($this->dados->id_grupo_acesso_area, $idGrupos)) {
            $liberado = true;
        }

        $historico = $this->historico->first();
        $retorno = ['icone' => '', 'status' => '', 'acao' => '', 'class' => ''];
        switch ($historico->situacao) {
            case "ABERTO":
                $retorno['icone'] = "fa-pause";
                $retorno['status'] = "AGUARDANDO INICIO";
                if ($podeIniciar || ($liberado && $this->sala_situacao == 'S')) {
                    $retorno['class'] = $this->sala_situacao == 'S' ? "tarefa-situacao" : "";
                    $retorno['acao'] = "iniciar";
                } else {
                    $retorno['acao'] = "aguardeExecucao";
                }
                break;
            case "CANCELADO":
                $retorno['icone'] = "fa-close text-danger";
                $retorno['status'] = "CANCELADA";
                $retorno['acao'] = "jaCancelada";
                break;
            case "CONCLUIDO":
                $retorno['icone'] = "fa-check text-success";
                $retorno['status'] = "FINALIZADA";
                $retorno['acao'] = "jaFinalizada";
                $retorno['class'] = "tarefa-finalizada";
                break;
            case "PENDENTE":
                if ($this->dados->tipo == "COMPRA") {
                    $retorno['class'] = $this->sala_situacao == 'S' ? "tarefa-situacao-warning" : "tarefa-andamento";
                    $retorno['status'] = "EFETUANDO COMPRA";
                    $retorno['icone'] = "fa-cart-plus text-info";
                    $retorno['acao'] = "escolherInsumos";
                } else {
                    $retorno['status'] = "EM ANDAMENTO";
                    $retorno['icone'] = "fa-clock-o text-info";
                    $retorno['acao'] = "decisao";
                    $retorno['class'] = "tarefa-andamento";
                }

                if (!$liberado) {
                    $retorno['acao'] = 'semPermissao';
                }
                break;
            case "REPORTADA":
                $retorno['icone'] = "fa-warning text-warning";
                $retorno['status'] = "REPORTADA";
                $retorno['acao'] = "jaReportada";
                break;
        }

        return $retorno;
    }

    /**
     * O último histórico da tarefa. Representa a situação atual da tarefa.
     *
     * @return HasOne
     */
    public function ultimoHistorico()
    {
        return $this->hasOne(HistoricoTarefa::class, 'id_tarefa_processo', 'id')
                    ->orderBy('data', 'DESC')
                    ->orderBy('id', 'DESC');
    }

    /**
     * Dados do histórico.
     */
    public function historico()
    {
        return $this->hasMany(HistoricoTarefa::class, 'id_tarefa_processo', 'id')
                    ->orderBy('data', 'DESC')
                    ->orderBy('id', 'DESC');
    }

    /**
     * Dados da tarefa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dados()
    {
        return $this->belongsTo(Tarefa::class, 'id_tarefa', 'id');
    }

    /**
     * Caso alguma outra tarefa processo esteja ligado a essa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tarefasFilhas()
    {
        return $this->tarefas()->with('tarefasFilhas.dados.area');
    }

    public function tarefas()
    {
        return $this->hasMany(TarefaProcesso::class, 'id_tarefa_processo', 'id')
                    ->orderBy('ordem', 'ASC');
    }

    /**
     * Dados do processo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function processo()
    {
        return $this->belongsTo(Processo::class, 'id_processo', 'id');
    }

    /**
     * Dados do usuário que abriu a tarefa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuarioAbertura()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_abertura', 'id');
    }

    /**
     * Dados do usuário que fechou a tarefa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuarioFechamento()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_fechamento', 'id');
    }

    /**
     * Documentos desta tarefa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documentos()
    {
        return $this->hasMany(TarefaDocumento::class, 'id_tarefa_processo', 'id')
                    ->orderBy('created_at', 'DESC');
    }

    /**
     * Todas as observações desta tarefa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function observacoes()
    {
        return $this->hasMany(Observacao::class, 'id_tarefa_processo', 'id')
                    ->orderBy('created_at', 'DESC');
    }

    /**
     * Todos os comentários desta tarefa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'id_tarefa_processo', 'id')
                    ->orderBy('created_at', 'DESC');
    }

    public function insumos()
    {
        return $this->belongsToMany(ProcessoInsumoTermoReferencia::class, 'tarefa_insumo', 'id_tarefa_processo', 'id_processo_insumo')
                    ->withPivot(['quantidade', 'created_at', 'updated_at']);
    }
}
