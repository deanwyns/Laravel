<?php

class Child extends ValidatableEloquent {
	protected $table = 'children';

	protected $fillable = [
		'first_name', 'last_name', 'adres_id', 'nrn','date_of_birth', 'parents_id' //nrn = national registry number
	];

	protected $rules = [
		'first_name' => 'required|max:35',
		'last_name' => 'required|max:55',
		'adres_id' => 'required',
		'nrn' => 'required| max: 15',
		'parents_id' => 'required',
		'date_of_birth' => 'Required'
	];

	public function registrations(){
		return $this->hasMany('Registration');
	}

	public function parent(){
		return $this->belongsTo('User');
	}

	public function adres(){
		return $this->hasOne('Address');
	}

	public $timestamps = false;
}