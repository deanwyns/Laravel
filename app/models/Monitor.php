<?php

class Monitor extends ValidatableEloquent {
	protected $table = 'users_monitors';
	
	protected $fillable =
		['first_name',
		'last_name',
		'telephone'];

	protected $rules = 
		['first_name' => 'required',
		'last_name' => 'required'];

	public function socialNetwork(){
		return $this->HasMany('SocialNetwork');
	}

	public function user() {
		return $this->morphOne('User', 'userable');
	}
	public $timestamps = false;
}