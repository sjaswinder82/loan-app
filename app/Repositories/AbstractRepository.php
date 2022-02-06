<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AbstractRepository {

    /**
     * instance for Model
     *
     * @var Model
     */
    private $model;

    /**
     * initialize dependencies
     *
     * @param Model $model
     */
    public function __construct(Model $model) {
        $this->model = $model;
    }

    /**
     * set Model
     *
     * @param Model $model
     * @return void
     */
    protected function setModel(Model $model) {
        $this->model = $model;
    }

    /**
     * get Model instance
     *
     * @return Model
     */
    protected function getModel() {
        return $this->model;
    }

    /**
     * get record by db ID
     *
     * @param  $id
     * @return Model
     * @throws ModelNotFoundException
     */
    public function getById($id) {
        return $this->getModel()->findOrFail($id);
    }

    /**
     * create new record
     *
     * @param array $payload
     * @return Model
     */
    public function create(array $payload) {
        return $this->getModel()->create($payload);
    }   

    /**
     * update record by ID
     *
     * @param int $id
     * @param array $payload
     * @return mixed
     */
    public function update($id, array $payload) {
        $model = $this->getById($id);

        $model->update($payload);

        return $model->refresh();
    }

    /**
     * fetch all records
     *
     * @param int $id
     * @param array $payload
     * @return mixed
     */
    public function all() {
        return $this->getModel()->all();
    }
}