<?php

class Parents extends ValidatableEloquent {
	protected $table = 'users_parents';

	protected $fillable =
		['first_name_mother',
		'last_name_mother',
		'nrn_mother',
		'address_id_mother',
		'first_name_father',
		'last_name_father',
		'nrn_father',
		'address_id_father',
		'phone_number'];


	protected $rules =
		['first_name_mother' => 'required_without:first_name_father',
		 'last_name_mother' => 'required_with:first_name_mother',
		 'nrn_mother' => 'required_with:first_name_mother|different:nrn_father|unique:users_parents|unique:users_parents,nrn_mother|unique:children,nrn', // zorgt voor uniek rijksregisternummer
		 'address_id_mother' => 'required',
		 'first_name_father' => 'required_without:first_name_mother',
		 'last_name_father' => 'required_with:first_name_father',
		 'nrn_father' => 'required_with:first_name_father|different:nrn_mother|unique:users_parents|unique:users_parents,nrn_mother|unique:children,nrn', // zorgt voor uniek rijksregisternummer
		 'address_id_father' => 'required',
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

	public function address_mother(){
		return $this->hasOne('Address');
	}

	public function address_father(){
		return $this->hasOne('Address');
	}
}