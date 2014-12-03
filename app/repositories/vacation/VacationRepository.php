<?php

interface VacationRepository {
	
	public function getByTitle($title, array $with = []);
	public function getById($id, array $with = []);
	
}