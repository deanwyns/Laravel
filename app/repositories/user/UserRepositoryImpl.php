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
<<<<<<< HEAD
	
=======
	/*getChildren*/
>>>>>>> 7fdf1f8d8b50f59a4e66ea0053a1d377b230fd3a
}