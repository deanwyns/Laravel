<?php

class Registration extends ValidatableEloquent {
	protected $table = 'registrations';

	protected $fillable = [
		'isPaid';
	];

	protected $rules = [
		'isPaid' => 'required, boolean',
		'child_id' => 'required',
		'vacation_id' => 'required'
	];

	//registered Child => subject that will go on the vacation
	public function child(){ 
		return $this->belongsTo('Child');
	}

	public function vacation(){
		return $this->belongsTo('Vacation');
	}

	public function 
		public $timestamps = false;
}