<?php

namespace App\Models;

use DB;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

class Usuario extends Authenticatable
{

    use Notifiable;

    protected $rememberTokenName = null;

    protected $table = 'usuario';

    protected $fillable = [
        'nome',
        'cpf',
        'matricula',
        'email',
        'id_funcao_area',
        'login',
        'senha',
        'id_cidade'
    ];

    protected $hidden = [
        'senha',
    ];

    /**
     * Retorna todos os tipos de processo que o usuário pode adicionar processos baseado nos seus grupos de acesso.
     *
     * @return array
     */
    public static function tiposDeProcesso()
    {
        $gruposArea = auth()->user()->gruposAcesso->pluck('id');
        $idsTipo = DB::table('tipo_processo_grupo_ac_area')
                     ->select('id_tipo_processo');

        if(!session('super_admin')){
            $idsTipo = $idsTipo->whereIn('id_grupo_acesso_area', $gruposArea->toArray());
        }

        $idsTipo = $idsTipo->get();

        $tiposProcessos = [];
        if (count($idsTipo)) {
            $idsTipo = $idsTipo->pluck('id_tipo_processo');
            $tiposProcessos = TipoProcesso::whereIn('id', $idsTipo->toArray())->orderBy('id')->get();
        }

        return $tiposProcessos;
    }

    /**
     * Busca todos os processos em aberto que tenham tarefas das mesmas areas que o usuário.
     *
     * @return Collection
     */
    public static function buscarProcessosDoUsuario()
    {
        // Busca os grupos de acesso/area que o usuário faz parte
        $idGrupos = auth()->user()->gruposAcesso->pluck('id')->toArray();

        // Agora vamos buscar os processos abertos
        $processos = Processo::with('tipo', 'area')->aberto()->whereHas('tarefas', function ($q) use ($idGrupos) {
            $q->whereHas('ultimoHistorico', function ($q) {
                // Que a situação da tarefa seja aberta ou em andamento
                $q->whereIn('status', ['ABERTO', 'PENDENTE']);
            })->whereHas('dados', function ($q) use ($idGrupos) {
                // Que a tarefa (dados) esteja em um dos grupos de acesso do usuário
                $q->whereIn('id_grupo_acesso_area', $idGrupos);
            });
        })->get();

        return $processos;
    }

    /**
     * Verifica se o usuário tem permissão para acessar a determinada rota.
     * Se tiver pelo menos um grupo dizendo que é permitida, este ganha
     *
     * @param Rota $rota
     *
     * @return bool
     */
    public function temPermissao($rota)
    {
        // Grupos que podem acessar essa rota
        $grupos = $rota->grupos->pluck('id')->toArray();

        // Grupos do usuário logado
        $gruposUsuario = array_unique($this->gruposAcesso->pluck('id_grupo_acesso')->toArray());

        $diferenca = array_diff($grupos, $gruposUsuario);

        return count($diferenca) < count($grupos);
    }

    /**
     * Retorna a cidade/uf do usuário.
     *
     * @return string
     */
    public function getCidadeUfAttribute()
    {
        return $this->cidade->descricao . '/' . $this->cidade->estado->sigla;
    }

    /**
     * Retorna a senha do usuário.
     *
     * @return mixed
     */
    public function getAuthPassword()
    {
        return $this->attributes['senha'];
    }

    /**
     * Retorna se algum dos grupos de acesso do usuário está marcado como super admin.
     *
     * @return bool
     */
    public function getSuperAdminAttribute()
    {
        return $this->gruposAcesso->filter(function ($grupo) {
                return $grupo->dadosGrupo->super_admin == 'S';
            })->count() > 0;
    }

    /**
     * Obtém o primeiro nome do usuário
     *
     * @param String
     */
    public function getPrimeiroNomeAttribute()
    {
        return array_first(explode(' ', $this->attributes['nome']));
    }

    /**
     * Remove a mascara do CPF antes de salvar no banco.
     *
     * @param string $cpf
     */
    public function setCpfAttribute($cpf)
    {
        $this->attributes['cpf'] = removerMascara($cpf);
    }

    /**
     * Encripta a senha antes de salvar.
     *
     * @param string $senha
     */
    public function setSenhaAttribute($senha)
    {
        if (!is_null($senha) && !empty($senha)) {
            $this->attributes['senha'] = bcrypt($senha);
        }
    }

    /**
     * Dados da cidade deste usuário.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'id_cidade', 'id');
    }

    /**
     * Todos os grupos de acesso deste usuário.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gruposAcesso()
    {
        return $this->belongsToMany(GrupoAcessoArea::class, 'usuario_grupo_acesso_area', 'id_usuario', 'id_grupo_acesso_area')
                    ->withPivot(['created_at', 'updated_at', 'id']);
    }

}
