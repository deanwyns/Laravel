<?php

class VacationRepositoryImpl extends AbstractRepository implements VacationRepository {

	public function __construct(Vacation $model) {
		$this->model = $model;
	}

	public function getByTitle($title, array $with = []) {
		$query = $this->make($with);

		return $query->where('title', '=', $title)->first();
	}
}