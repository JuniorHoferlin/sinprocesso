<?php

namespace App\Models;

use Illuminate\Support\Collection;

class Processo extends BaseModel
{

    public static $status = [
        'ABERTO'     => 'ABERTO',
        'FINALIZADO' => 'FINALIZADO',
        'BLOQUEADO'  => 'BLOQUEADO',
    ];

    protected $dates = [
        'data_inicio',
        'data_fim'
    ];

    protected $table = 'processo';

    public static function buscarTiposCompras($periodo)
    {
        $retorno = \DB::select("
              SELECT 
                  COUNT(p.id) as quantidade,
                  M.descricao,
                  M.id 
              FROM processo p 
              LEFT JOIN modalidades M ON M.id = p.id_modalidade 
              where 
                p.status = 'ABERTO' AND 
                p.data_inicio >= '" . $periodo['inicio'] . "' AND
                (p.data_fim <= '" . $periodo['fim'] . "' OR p.data_fim IS NULL)
              GROUP BY M.id, M.descricao
        ");

        return $retorno;
    }

    /**
     * Adiciona uma nova observação em um processo.
     *
     * @param string $descricao
     *
     * @return Collection
     */
    public function adicionarObservacao($descricao)
    {
        $this->observacoes()->create(['descricao' => $descricao]);

        return $this->observacoes()->get();
    }

    /**
     * Todas as observacoes ligadas a este processo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function observacoes()
    {
        return $this->hasMany(Observacao::class, 'id_processo', 'id')->whereNull('id_tarefa_processo')->orderBy('created_at', 'DESC');
    }

    /**
     * Verifica se o processo tem pelo menos uma tarefa do tipo compra que ainda não foi enviada para sala de situação
     * que ainda não foi finalizada nem iniciada.
     *
     * @return bool
     */
    public function permiteSalaSituacao()
    {
        return $this->tarefas->filter(function ($tarefa) {
                return $tarefa->dados->tipo == 'COMPRA' &&
                    $tarefa->sala_situacao == 'N' &&
                    $tarefa->ultimoHistorico->situacao == 'ABERTO';
            })->count() > 0;
    }

    /**
     * Verifica se o processo tem alguma tarefa que está em sala de situação.
     *
     * @return bool
     */
    public function estaEmSalaSituacao()
    {
        return $this->tarefas->filter(function ($tarefa) {
                return $tarefa->dados->tipo == 'COMPRA' && $tarefa->sala_situacao == 'S' && $tarefa->data_finalizado == null;
            })->count() > 0;
    }

    /**
     * Adiciona um novo comentário em um processo.
     *
     * @param string $descricao
     *
     * @return Collection
     */
    public function adicionarComentario($descricao)
    {
        $this->comentarios()->create(['descricao' => $descricao]);

        return $this->comentarios()->get();
    }

    /**
     * Todos os comentários ligados a este processo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'id_processo', 'id')->whereNull('id_tarefa_processo')->orderBy('created_at', 'DESC');
    }

    /**
     * Finaliza o processo.
     */
    public function finalizar()
    {
        $this->attributes['status'] = "FINALIZADO";
        $this->attributes['data_fim'] = date('Y-m-d H:i:s');

        // Gera o histórico do processo
        ProcessoHistorico::create(
            [
                'id_usuario'  => auth()->user()->id,
                'id_processo' => $this->attributes['id'],
                'status'      => 'FINALIZADO',
            ]
        );

        return $this->update();
    }

    /**
     * Retorna a soma dos prazo das tarefas em
     *
     * @return string
     */
    public function getPrazoAttribute()
    {
        $prazo = 0;
        $this->tarefas->each(function ($tarefa) use (&$prazo) {
            $prazo = $prazo + $tarefa->dados->prazo_minutos;
        });

        return $prazo * 60;
    }

    /**
     * Retorna o prazo do processo em dias.
     *
     * @return string
     */
    public function getPrazoDiasAttribute()
    {
        $prazoSegundos = $this->prazo;

        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$prazoSegundos");

        return $dtF->diff($dtT)->format('%a');
    }

    /**
     * Retorna a situação do prazo do processo.
     *
     * @return array
     */
    public function getPrazoSituacaoAttribute()
    {
        $retorno = ['situacao' => 'No prazo', 'icone' => 'fa-thumbs-up'];

        // Dias em execucação é calculado pela classe CalculaDiasExecucao
        $diasEmAberto = $this->dias_execucao;

        if ($diasEmAberto > $this->prazo_dias) {
            $retorno['situacao'] = 'Atrasado';
            $retorno['icone'] = 'fa-warning';
        }

        return $retorno;
    }

    /**
     * Retorna a soma do tempo decorrente das tarefas desse processo
     *
     * @return string
     */
    public function getTempoAttribute()
    {
        $tempo = 0;
        $this->tarefas->each(function ($tarefa) use (&$tempo) {
            $tempo = $tempo + $tarefa->duracao;
        });

        return $tempo;
    }

    /**
     * Retorna a classe utilizada para exibir o status do processo.
     *
     * @return string
     */
    public function getStatusClasseAttribute()
    {
        switch ($this->attributes['status']) {
            case self::$status['FINALIZADO']:
                $classe = 'default';
                break;
            case self::$status['BLOQUEADO']:
                $classe = 'danger';
                break;
            default:
                $classe = 'primary';
        }

        return $classe;
    }

    /**
     * Retorna detalhes das tarefas do processo.
     *
     * @return array
     */
    public function getDetalhesTarefasAttribute()
    {
        $tarefas = $this->tarefas;
        $total = count($tarefas);
        $completado = 0;

        foreach ($tarefas as $tarefa) {
            $historicoRecente = $tarefa->historico->first();
            if ($historicoRecente && $historicoRecente->situacao != "ABERTO" && $historicoRecente->situacao != "PENDENTE") {
                $completado++;
            }
        }

        return ['total' => $total, 'concluido' => $completado];
    }

    /**
     * Retorna a porcentagem de conclusão do processo.
     *
     * @return int
     */
    public function getPorcentagemConcluidoAttribute()
    {
        $detalhesTarefas = $this->detalhes_tarefas;
        if ($detalhesTarefas['total'] > 0) {
            $porcentagem = floor((100 / $detalhesTarefas['total']) * $detalhesTarefas['concluido']);
        } else {
            $porcentagem = 0;
        }

        return $porcentagem;
    }

    /**
     * Retorna o codigo do processo.
     *
     * @return int
     */
    public function getCodigoAttribute()
    {
        return str_pad($this->attributes['id'], 4, '0', 0);
    }

    /**
     * Retorna o valor final do processo
     *
     * @return int
     */
    public function getValorProcessoAttribute()
    {
        $valor = 0;
        $this->insumos->each(function ($processoInsumoTermoReferencia) use (&$valor) {
            $valor = $valor + ($processoInsumoTermoReferencia->insumoTermo->valor * $processoInsumoTermoReferencia->quantidade);
        });

        return $valor;
    }

    /**
     * Retorna se o processo está bloqueado ou não.
     *
     * @return bool
     */
    public function getBloqueadoAttribute()
    {
        return $this->attributes['status'] == self::$status['BLOQUEADO'];
    }

    /**
     * Retorna se o processo está aberto ou não.
     *
     * @return bool
     */
    public function getAbertoAttribute()
    {
        return $this->attributes['status'] == self::$status['ABERTO'];
    }

    /**
     * Retorna se o processo está finalizado ou não.
     *
     * @return bool
     */
    public function getFinalizadoAttribute()
    {
        return $this->attributes['status'] == self::$status['FINALIZADO'];
    }

    /**
     * Aplica o escopo que so irá retornar processos abertos.
     *
     * @param $query
     */
    public function scopeAberto($query)
    {
        return $query->where('status', Processo::$status['ABERTO']);
    }

    /**
     * Todas as tarefas ligadas diretamente a este processo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tarefas()
    {
        return $this->hasMany(TarefaProcesso::class, 'id_processo', 'id')
                    ->orderBy('ordem', 'ASC');
    }

    /**
     * O tipo deste processo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipo()
    {
        return $this->belongsTo(TipoProcesso::class, 'id_tipo_processo', 'id');
    }

    /**
     * Dados do termo de referencia deste processo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function termoReferencia()
    {
        return $this->belongsTo(TermoReferencia::class, 'id_termo_referencia', 'id');
    }

    /**
     * Todas as respostas do formulario deste processo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function respostasFormulario()
    {
        return $this->hasMany(ProcessoRespostaFormulario::class, 'id_processo', 'id');
    }

    /**
     * Dados do formulario deste processo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function formulario()
    {
        return $this->belongsTo(Formulario::class, 'id_formulario', 'id');
    }

    /**
     * Dados da modalidade deste processo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function modalidade()
    {
        return $this->belongsTo(Modalidade::class, 'id_modalidade', 'id');
    }

    /**
     * Dados do plano de acesso deste processo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function planoAcao()
    {
        return $this->hasOne(PlanoAcao::class, 'id_processo', 'id');
    }

    /**
     * Todos os documentos associados a este processo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function documentos()
    {
        return $this->belongsToMany(DocumentoPadrao::class, 'processo_documento', 'id_processo', 'id_documento')
                    ->withPivot(['created_at', 'updated_at']);
    }

    /**
     * Todos os anexos ligados a este processo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function anexos()
    {
        return $this->hasMany(Anexo::class, 'id_processo', 'id')->orderBy('created_at', 'DESC');
    }

    /**
     * A area no qual o processo está ligado.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function area()
    {
        return $this->belongsTo(Area::class, 'id_area', 'id');
    }

    /**
     * Todos os insumos ligados ao processo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function insumos()
    {
        return $this->hasMany(ProcessoInsumoTermoReferencia::class, 'id_processo', 'id');
    }

}
