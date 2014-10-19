<?php

abstract class AbstractRepository {

	/**
	 * Eloquent model waarop "query's" op aangeroepen
	 * kunnen worden.
	 * @var Model
	 */
	protected $model;

	/**
	 * Make a new instance of the entity to query on
	 *
	 * @param array $with
	 */
	public function make(array $with = []) {
		return $this->model->with($with);
	}

	/**
	 * Find all entities
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function all() {
		return $this->model->all();
	}

	/**
	 * Find an entity by id
	 *
	 * @param int $id
	 * @param array $with
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function getById($id, array $with = []) {
		$query = $this->make($with);
	 
		return $query->find($id);
	}
}