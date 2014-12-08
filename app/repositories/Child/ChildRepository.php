<?php

interface ChildRepository {
	
	public function getById($id, array $with = []);

	public function getRegistrations($child);

	public function getAddress($child);
	
}