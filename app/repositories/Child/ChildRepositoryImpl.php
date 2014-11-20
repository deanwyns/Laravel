<?php

class ChildRepositoryImpl extends AbstractRepository implements ChildRepository {

	public function __construct(Child $model) {
		$this->model = $model;
	}

	public function getById($id, array $with = []) {
		$query = $this->make($with);
		return $query->where('id', '=', $id)->first();
	}
}