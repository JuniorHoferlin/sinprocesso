<?php

namespace App\Database\Eloquent\Relations;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Relation;

class CustomBelongsToMany extends Relation
{

    /**
     * @var Dispatcher
     */
    private $dispatcher;

    public function __construct(BelongsToMany $belongsToMany)
    {
        $this->belongsToMany = $belongsToMany;
        $this->dispatcher = app('Illuminate\Contracts\Events\Dispatcher');
    }

    public function sync($ids, $detaching = true, $model = null)
    {
        // Salva os registros antes de altera-los na classe
        $this->belongsToMany->antes = $this->belongsToMany->get();
        $retorno = $this->belongsToMany->sync($ids, $detaching, $model);

        // Salva os registros depois de altera-los na classe
        $this->belongsToMany->depois = $this->belongsToMany->get();

        // executa o evento
        $this->dispatcher->fire('eloquent.pivot', [$retorno, $this->belongsToMany]);

        return $retorno;
    }

    /**
     * Chama os metodos pertencenes a classe principal do BelongsToMany.
     *
     * @param $method
     * @param $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->belongsToMany, $method], $parameters);
    }

    public function withPivot($columns)
    {
        $this->belongsToMany->withPivot($columns);

        return $this;
    }

    /**
     * Set the base constraints on the relation query.
     *
     * @return void
     */
    public function addConstraints()
    {
        return $this->belongsToMany->addConstraints();
    }

    /**
     * Set the constraints for an eager load of the relation.
     *
     * @param  array $models
     *
     * @return void
     */
    public function addEagerConstraints(array $models)
    {
        return $this->belongsToMany->addEagerConstraints($models);
    }

    /**
     * Initialize the relation on a set of models.
     *
     * @param  array $models
     * @param  string $relation
     *
     * @return array
     */
    public function initRelation(array $models, $relation)
    {
        return $this->belongsToMany->initRelation($models, $relation);
    }

    /**
     * Match the eagerly loaded results to their parents.
     *
     * @param  array $models
     * @param  \Illuminate\Database\Eloquent\Collection $results
     * @param  string $relation
     *
     * @return array
     */
    public function match(array $models, Collection $results, $relation)
    {
        return $this->belongsToMany->match($models, $results, $relation);
    }

    /**
     * Get the results of the relationship.
     *
     * @return mixed
     */
    public function getResults()
    {
        return $this->belongsToMany->getResults();
    }

    /**
     * Get the related model of the relation.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getRelated()
    {
        return $this->belongsToMany->getRelated();
    }

    /**
     * Get the fully qualified parent key name.
     *
     * @return string
     */
    public function getQualifiedParentKeyName()
    {
        return $this->belongsToMany->parent->getQualifiedKeyName();
    }

    /**
     * Get the underlying query for the relation.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getQuery()
    {
        return $this->belongsToMany->getQuery();
    }

}