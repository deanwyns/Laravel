<?php

class ChildRepositoryImpl extends AbstractRepository implements ChildRepository {

	public function __construct(Child $model) {
		$this->model = $model;
	}

	public function getById($id, array $with = []) {
		$query = $this->make($with);
		return $query->where('id', '=', $id)->first();
	}

	public function getRegistrations($child){
		if($child->registrations != null)
			return $child->registrations;
		return [];
	}

	public function getAddress($child){
		return $child->address_id;
	}
}