<?php

interface UserRepository {
	
	public function getByEmail($email, array $with = []);
	public function getByUsername($username, array $with = []);
	
}