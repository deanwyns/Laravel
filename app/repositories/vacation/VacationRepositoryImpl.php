<?php

class VacationRepositoryImpl extends AbstractRepository implements VacationRepository {

	public function __construct(Vacation $model) {
		$this->model = $model;
	}

	public function getByTitle($title, array $with = []) {
		$query = $this->make($with);

		return $query->where('title', '=', $title)->first();
	}

	public function getById($id, array $with = []){
		$query = $this->make($with);
		
		return $query->where('id', '=', $id)->first();
	}

	public function getRegistrations($vacation){
		return $vacation->registrations;
	}

	public function getCategories() {
		return Category::all();
	}

	public function createCategory($attributes) {
		return Category::create($attributes);
	}
}