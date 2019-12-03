<?php

namespace App\Models;

class Auditoria extends BaseModel
{

    protected $table = 'auditoria';

    /**
     * Todas as ações desta auditoria.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function acoes()
    {
        return $this->hasMany(AuditoriaAcao::class, 'id_auditoria', 'id')->orderBy('created_at', 'ASC');
    }

    /**
     * O tipo da rota.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tipo()
    {
        return $this->belongsTo(TipoRota::class, 'id_perm_tipo_rota', 'id');
    }

    /**
     * A rota em que a ação foi executada.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rota()
    {
        return $this->belongsTo(Rota::class, 'id_perm_rota', 'id');
    }

    /**
     * Dados do usuário.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id');
    }
}
