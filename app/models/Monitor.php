<?php

class Monitor extends ValidatableEloquent {
	protected $table = 'users_monitors';
	
	protected $fillable =
		[];

	public function user() {
		return $this->morphOne('User', 'userable');
	}
}