<?php

class Monitor extends ValidatableEloquent {
	protected $table = 'users_monitors';
	
	protected $scopes =
		['user.public', 'user.monitor'];

	public function user() {
		return $this->morphOne('User', 'userable');
	}
}