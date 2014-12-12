<?php

class Registration extends ValidatableEloquent {
	protected $table = 'registrations';

	protected $fillable = [
		'is_paid',
		'child_id',
		'vacation_id',
		'first_name',
		'last_name',
		'address_id'
	];

	protected $rules = [
		'is_paid' => 'required',
		'child_id' => 'required',
		'vacation_id' => 'required',
		'first_name' => 'required',
		'last_name' => 'required',
		'address_id' => 'required'
	];

	//registered Child => subject that will go on the vacation
	public function child() { 
		return $this->belongsTo('Child');
	}

	public function vacation() {
		return $this->belongsTo('Vacation');
	}

	public function address() {
		return $this->belongsTo('Address');
	}

	public $timestamps = false;
}