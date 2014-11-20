<?php

class Admin extends ValidatableEloquent {
	protected $table = 'users_admins';

	protected $scopes =
		['user.public', 'user.admin'];

	public function user() {
		return $this->morphOne('User', 'userable');
	}
}