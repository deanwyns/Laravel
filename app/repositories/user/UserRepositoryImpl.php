<?php

class UserRepositoryImpl extends AbstractRepository implements UserRepository {

	public function __construct(User $model) {
		$this->model = $model;
	}

	public function getByEmail($email, array $with = []) {
		$query = $this->make($with);

		return $query->where('email', '=', $email)->first();
	}

	public function getByUsername($username, array $with = []) {
		$query = $this->make($with);

		return $query->where('username', '=', $username)->first();
	}

}