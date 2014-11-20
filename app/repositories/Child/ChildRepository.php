<?php

interface ChildRepository {
	
	public function getById($id, array $with = []);

	
}