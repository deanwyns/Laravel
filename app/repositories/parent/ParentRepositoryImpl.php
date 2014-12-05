<?php

class ParentRepositoryImpl extends AbstractRepository implements ParentRepository {

	public function __construct(Parent $model) {
		$this->model = $model;
	}

	public function getById($id, array $with = []) {
		$query = $this->make($with);
		return $query->where('id', '=', $id)->first();
	}

	public function getChildren(){
		return $this->children;
	}

	public function getAddress(){
		return [$this->mother_address, $this->father_address];
	}
}