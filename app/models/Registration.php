<?php

class Registration extends ValidatableEloquent {
	protected $table = 'registrations';

	protected $fillable = [
		'is_paid',
		'child_id',
		'vacation_id',
		'facturation_first_name',
		'facturation_last_name',
		'facturation_address_id'
	];

	protected $rules = [
		'child_id' => 'required',
		'vacation_id' => 'required',
		'facturation_first_name' => 'required',
		'facturation_last_name' => 'required',
		'facturation_address_id' => 'required'
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