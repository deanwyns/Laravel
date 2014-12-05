<?php

interface ParentRepository {
	
	public function getById($id, array $with = []);

	public function getChildren(array $with = []);

	public function getAddress(array $with = []);
	
}