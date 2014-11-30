<?php

class Child extends ValidatableEloquent {
	protected $table = 'children';

	protected $fillable = [
		'firstName', 'lastName', 'streetName', 'houseNumber','city', 'postalCode', 'nrn', 'parents_id' //nrn = national registry number
	];

	protected $rules = [
		'firstName' => 'required|max:35',
		'lastName' => 'required|max:55',
		'streetName' => 'required| max: 100',
		'houseNumber' => 'required|max: 5',
		'city' => 'required| max: 55',
		'postalCode' => 'required|digits_between:1,4',
		'nrn' => 'required| max: 15',
		'parents_id' => 'required'
	];

	public function registrations(){
		return $this->hasMany('Registration');
	}

	public function parent(){
		return $this->belongsTo('User');
	}
		public $timestamps = false;
}