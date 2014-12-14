<?php

interface UserRepository {
	
	public function getByEmail($email, array $with = []);
	public function getByUsername($username, array $with = []);

	public function createParents($attributes);
	public function createMonitor($attributes);
	public function createAdmin($attributes);

	public function getChildren($user);
	public function getMotherAddress($user);
	public function getFatherAddress($user);

	public function searchMonitor($searchQuery);
}