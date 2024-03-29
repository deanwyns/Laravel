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
	
	public function createParents($attributes) {
		$parents = Parents::create($attributes);
		if($parents) {
			$attributes['password'] = Hash::make(Input::get('password'), ['rounds' => 12]);
			$this->model->fill($attributes);

			if($parents->user()->save($this->model)) {
				return true;
			}
		}

		return false;
	}

	public function createMonitor($attributes) {
		$monitor = Monitor::create($attributes);
		if($monitor) {
			$attributes['password'] = Hash::make(Input::get('password'), ['rounds' => 12]);
			$attributes['userable_id'] = $monitor->id;
			$this->model->fill($attributes);

			if($monitor->user()->save($this->model)) {
				return true;
			}
		}

		return false;
	}

	public function createAdmin($attributes) {
		$admin = Admin::create($attributes);
		if($admin) {
			$attributes['password'] = Hash::make(Input::get('password'), ['rounds' => 12]);
			$attributes['userable_id'] = $admin->id;
			$this->model->fill($attributes);

			if($admin->user()->save($this->model)) {
				return true;
			}
		}

		return false;
	}

	public function getChildren($user){
		if($user->userable->children != null)
			return $user->userable->children;
		return [];
	}

	public function searchMonitor($searchQuery) {
		$regex = str_replace(' ', '|', $searchQuery);
		$rawQuery = 'first_name REGEXP \'' . $regex . '\' OR last_name REGEXP \'' . $regex . '\'';
		return Monitor::whereRaw($rawQuery)->get();
	}
}