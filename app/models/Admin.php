<?php

class Admin extends ValidatableEloquent {
	protected $table = 'users_admins';

	protected $fillable =
		[];
		
	public function user() {
		return $this->morphOne('User', 'userable');
	}

	public $timestamps = false;
}