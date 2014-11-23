<?php

class Parents extends ValidatableEloquent {
	protected $table = 'users_parents';

	protected $fillable =
		['first_name_mother',
		'last_name_mother',
		'nrn_mother',
		'first_name_father',
		'last_name_father',
		'nrn_father',
		'phone_number'];

	protected $rules =
		['first_name_mother' => 'required_without:first_name_father',
		 'last_name_mother' => 'required_with:first_name_mother',
		 'nrn_mother' => 'required_with:first_name_mother',
		 'first_name_father' => 'required_without:first_name_mother',
		 'last_name_father' => 'required_with:first_name_father',
		 'nrn_father' => 'required_with:first_name_father',
		 'phone_number' => 'required'];

	public function user() {
		return $this->morphOne('User', 'userable');
	}

	public function scopes() {
		return $this->scopes;
	}

	public function children(){
		return $this->hasMany('Child');
	}
}