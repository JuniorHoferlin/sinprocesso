<?php

namespace App\Models;

use App\Database\Eloquent\Relations\CustomBelongsToMany;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel
 * @package App
 *
 * Aqui vai todos os métodos que todos os nossos models tem em comum.
 */
class BaseModel extends Model
{

    protected $guarded = ['id'];

    /**
     * Necessário para a auditoria.
     *
     * @param string $related
     * @param null $table
     * @param null $foreignKey
     * @param null $otherKey
     * @param null $relation
     *
     * @return CustomBelongsToMany
     */
    public function belongsToMany($related, $table = null, $foreignKey = null, $otherKey = null, $relation = null)
    {
        $belongs = parent::belongsToMany($related, $table, $foreignKey, $otherKey, $relation);

        return new CustomBelongsToMany($belongs);
    }
}
