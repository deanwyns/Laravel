<?php

class AddressRepositoryImpl extends AbstractRepository implements AddressRepository {

	public function __construct(Address $model) {
		$this->model = $model;
	}

	public function getById($id, array $with = []) {
		$query = $this->make($with);
		return $query->where('id', '=', $id)->first();
	}
}