<?php

interface VacationRepository {
	
	public function getByTitle($title, array $with = []);
	public function getById($id, array $with = []);
	public function getCategories();
	public function createCategory($attributes);
	public function getRegistrations($vacation);
	public function getLikes($vacation);
	
}