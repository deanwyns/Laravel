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
		['first_name_mother' => 'required_without:first_name_father|required_without:last_name_father',
		 'last_name_mother' => 'required_with:first_name_mother|required_with:nrn_mother',
		 'nrn_mother' => 'required_with:first_name_mother|required_with:last_name_mother|different_if_exists:nrn_father|unique:users_parents|unique:users_parents,nrn_father|unique:children,nrn', // zorgt voor uniek rijksregisternummer
		 'first_name_father' => 'required_without:first_name_mother|required_without:last_name_mother',
		 'last_name_father' => 'required_with:first_name_father',
		 'nrn_father' => 'required_with:first_name_father|required_with:last_name_father|different_if_exists:nrn_mother|unique:users_parents|unique:users_parents,nrn_mother|unique:children,nrn', // zorgt voor uniek rijksregisternummer
		 'phone_number' => 'required|digits_between:9,10'
		 ];

	public $timestamps = false;

	public function user() {
		return $this->morphOne('User', 'userable');
	}

	public function likes() {
		return $this->hasMany('Like');
	}

	public function children() {
		return $this->hasMany('Child');
	}
}