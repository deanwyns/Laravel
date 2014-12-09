<?php

class Registration extends ValidatableEloquent {
	protected $table = 'registrations';

	protected $fillable = [
		'is_paid',
		'child_id',
		'vacation_id'
	];

	protected $rules = [
		'is_paid' => 'required',
		'child_id' => 'required',
		'vacation_id' => 'required'
	];

	//registered Child => subject that will go on the vacation
	public function child() { 
		return $this->belongsTo('Child');
	}

	public function vacation() {
		return $this->belongsTo('Vacation');
	}

	public $timestamps = false;
}