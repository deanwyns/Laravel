<?php

class RegistrationRepositoryImpl extends AbstractRepository implements RegistrationRepository {

	public function __construct(Registration $model) {
		$this->model = $model;
	}

	public function getById($id, array $with = []) {
		$query = $this->make($with);
		return $query->where('id', '=', $id)->first();
	}
	
}