<?php

class Address extends ValidatableEloquent {
	protected $table = 'addresses';

	protected $fillable = [
		'street_name', 'house_number','city', 'postal_code'
	];

	protected $rules = [
		'street_name' => 'required| max: 100',
		'house_number' => 'required|max: 5',
		'city' => 'required| max: 55',
		'postal_code' => 'required|digits_between:1,4' // enkel belgische postcodes
	];

	public $timestamps = false;
}