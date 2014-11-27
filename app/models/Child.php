<?php

class Child extends ValidatableEloquent {
	protected $table = 'children';

	protected $fillable = [
		'firstName', 'lastName', 'streetName', 'houseNumber','city','nrn' //nrn = national registry number
	];

	protected $rules = [
		'firsName' => 'required|max:35',
		'lastName' => 'required|max:55',
		'streetName' => 'required| max: 100',
		'houseNumber' => 'required|max: 5',
		'city' => 'required| max: 55',
		'nrn' => 'required| max: 15',
		'user_id' => 'required'
	];

	public function registrations(){
		return $this->hasMany('Registration');
	}

	public function parent(){
		return $this->belongsTo('User');
	}
		public $timestamps = false;
}