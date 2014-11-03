<?php

interface VacationRepository {
	
	public function getByTitle($title, array $with = []);
	
}