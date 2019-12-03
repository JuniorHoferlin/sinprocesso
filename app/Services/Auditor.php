<?php

namespace App\Services;

use App\Models\Auditoria;
use App\Models\AuditoriaAcao;
use App\Models\Rota;
use Cache;
use DB;
use Exception;
use Illuminate\Database\Eloquent\Relations\Relation;
use Route;

class Auditor
{

    /**
     * Cria uma ação de auditoria. Um registro de auditoria pode ter várias ações.
     *
     * @param \Illuminate\Database\Eloquent\Model $evento Model eloquent que está sendo alterado
     * @param array $alterado Conteúdo que foi alterado
     * @param array $original Conteúdo original
     * @param array $acao A ação realizada no conteudo. (insert(I), delete(D) ou update(U))
     *
     * @return void
     */
    public function adicionaAlteracoes($evento, $alterado, $original = array(), $acao)
    {
        $dados['tabela'] = $evento->getTable();
        $dados['id_registro'] = $evento->getKey();
        $dados['acao_tabela'] = $acao;
        $dados['dados_new'] = $alterado;
        $dados['dados_old'] = $original;
        $dados['dados_alt'] = array_diff($alterado, $original);

        $idAuditoria = session('id_auditoria');
        if (is_null($idAuditoria)) {
            $idAuditoria = $this->auditar()->id;
            session(['id_auditoria' => $idAuditoria]);
        }
        $dados['id_auditoria'] = $idAuditoria;

        return AuditoriaAcao::create($dados);
    }

    /**
     * Grava na tabela de auditoria um registro representando uma ação no sistema.
     *
     * @return Auditoria
     */
    public function auditar()
    {
        $dados = $this->setarDadosAuditoria();

        return Auditoria::create($dados);
    }

    /**
     * Seta os dados em comum que todos registros de auditoria tem.
     *
     * @throws Exception
     *
     * @return array
     */
    private function setarDadosAuditoria()
    {
        $dados = [];

        $dados['endereco_ipv4'] = enderecoIp();

        // Se o request for JSON pegamos
        if (count($_POST) == 0) {
            $_POST = json_decode(file_get_contents('php://input'), true);
        }

        $dados['dados_post'] = json_encode($_POST);
        if (is_null($dados['dados_post'])) {
            $dados['dados_post'] = [];
        }
        $dados['dados_get'] = json_encode($_GET);
        $dados['dados_server'] = json_encode($this->removerDadosSensiveis());
        $dados['id_usuario'] = auth()->user()->id;

        // Se estiver rodando no console, vamos dizer que a rota é uma rota diferente, pois não há rotas quando roda pelo console
        if (app()->runningInConsole()) {
            $rota = 'terminal';
        } else {
            $rota = Route::current()->getName();
        }

        if (strstr($rota, '.post')) {
            $rota = str_replace('.post', '', $rota);
        }

        // TODO: poderia introduzir o CACHE das rotas aqui
        $metodo = Rota::where('rota', $rota)->first();
        if (is_null($metodo)) {
            throw new Exception("Rota {$rota} não encontrada para auditoria. Você já criou esta rota no banco?");
        }

        $dados['id_perm_rota'] = $metodo->id;
        $dados['id_perm_tipo_rota'] = $metodo->id_perm_tipo_rota;

        return $dados;
    }

    /**
     * Remove dados sensíveis da variavel global $_SERVER.
     *
     * @return mixed
     */
    public function removerDadosSensiveis()
    {
        $server = $_SERVER;
        $manter = ['HTTP_USER_AGENT', 'HTTP_REFERER', 'REMOTE_ADDR', 'REQUEST_SCHEME', 'REQUEST_METHOD', 'QUERY_STRING', 'REQUEST_URI', 'REQUEST_TIME'];
        foreach ($server as $chave => $conteudo) {
            if (!in_array($chave, $manter)) {
                unset($server[$chave]);
            }
        }

        return $server;
    }

    /**
     * Adiciona uma alteração que foi realizada em uma tabela de join.
     *
     * @param array $alteracoes
     * @param Relation $relation
     *
     * @return void
     */
    public function adicionarAlteracaoDeJoin(array $alteracoes, Relation $relation)
    {
        $otherKey = explode('.', $relation->getQualifiedRelatedKeyName())[1];
        $foreignKey = explode('.', $relation->getQualifiedForeignKeyName())[1];

        $dadosAuditoria['tabela'] = $relation->getTable();

        $idAuditoria = session('id_auditoria');
        if (is_null($idAuditoria)) {
            $idAuditoria = $this->auditar()->id;
            session(['id_auditoria' => $idAuditoria]);
        }
        $dadosAuditoria['id_auditoria'] = $idAuditoria;

        foreach ($alteracoes as $tipo => $ids) {
            $dadosAuditoria['acao_tabela'] = $this->decideAcao($tipo);
            foreach ($ids as $id) {
                $dadosAuditoria = $this->setaDadosOldNew($dadosAuditoria, $relation, $id, $otherKey);
                // TALVES ESSE TENHA QUE SER O ID DA CHAVE PRIMARIA DA TABELA DE JOIN
                $dadosAuditoria['id_registro'] = $id;
                AuditoriaAcao::create($dadosAuditoria);
            }
        }
    }

    private function decideAcao($tipo)
    {
        switch ($tipo) {
            case 'attached':
                $acao = 'I';
                break;
            case 'updated':
                $acao = 'U';
                break;
            case 'detached':
                $acao = 'D';
                break;
        }

        return $acao;
    }

    private function setaDadosOldNew($dadosAuditoria, $relation, $id, $otherKey)
    {
        $dadosAuditoria['dados_old'] = [];
        $dadosAuditoria['dados_new'] = [];
        $dadosAuditoria['dados_alt'] = [];

        $antigo = $relation->antes->filter(function ($registro) use ($id, $otherKey) {
            if ($registro->pivot->{$otherKey} == $id) {
                return $registro;
            }
        })->first();
        if ($antigo) {
            $dadosAuditoria['dados_old'] = $antigo->pivot->getAttributes();
        }

        $novo = $relation->depois->filter(function ($registro) use ($id, $otherKey) {
            if ($registro->pivot->{$otherKey} == $id) {
                return $registro;
            }
        })->first();
        if ($novo) {
            $dadosAuditoria['dados_new'] = $novo->pivot->getAttributes();
        }

        $dadosAuditoria['dados_alt'] = array_diff($dadosAuditoria['dados_new'], $dadosAuditoria['dados_old']);
        $dadosAuditoria['dados_new'] = $dadosAuditoria['dados_new'];
        $dadosAuditoria['dados_old'] = $dadosAuditoria['dados_old'];

        return $dadosAuditoria;
    }

}