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
		'phone_number'];/*,
		'streetName_mother',
		'houseNumber_mother',
		'city_mother',
		'postalCode_mother',

		'streetName_father,
		'houseNumber_father,
		'city_father'
		'postalCode_father'
		];*/


	protected $rules =
		['first_name_mother' => 'required_without:first_name_father',
		 'last_name_mother' => 'required_with:first_name_mother',
		 'nrn_mother' => 'required_with:first_name_mother',
		 'first_name_father' => 'required_without:first_name_mother',
		 'last_name_father' => 'required_with:first_name_father',
		 'nrn_father' => 'required_with:first_name_father',
		 'phone_number' => 'required']; /*,
		
		'streetName_mother' => 'required| max: 100',
		'houseNumber_mother' => 'required|max: 5',
		'city_mother' => 'required| max: 55',
		'postalCode_mother' => 'required|digits_between:1,4',

		'streetName_father' => 'required| max: 100',
		'houseNumber_father' => 'required|max: 5',
		'city_father' => 'required| max: 55',
		'postalCode_father' => 'required|digits_between:1,4'
];*/
	//bovenstaande code in't geval van dat moeder en vader een verschillend (gedomicilieerd) adres kunnen hebben.


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