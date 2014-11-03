<?php

class Vacacation extends ValidatableEloquent {
	protected $table = 'vacations';

	protected $fillable = [
		'title', 'description', 
		'promo_text', // korte beschrijving (voor weergave in lijsten)
		'location', 
		'min_age', 'max_age', // min en max leeftijd om te mogen participeren
		 'transportation', 'max_participants',
		'base_cost', // Prijs wanneer geen enkele ouder lid is van Bond Moysson 
		'one_bm_member_cost', 'two_bm_member_cost' // idem base_cost maar waar respectievelijk 1 & 2 ouders lid van Bond Moysson
	]

	protected $rules = [
		'title' => 'required|max:140|unique:vacations',
		'description' => 'max: 5000',
		'promo_text' => 'max: 280',
		'location' => 'required|max:280',
		'min_age' => 'digits:2',
		'max_age' => 'digits:2',
		'transportation' => 'max: 280',
		'max_participants' => 'numeric|max:3',
		'base_cost' => 'integer|required', 
		'one_bm_member_cost' => 'integer|required',
		'two_bm_member_cost' => 'integer|required'
		// base_cost, one & two_bm_member_cost voorlopig integer moet eigenlijk een kommagetal of currency worden
	]
		//timestamps zijn niet nodig voor deze 'tabel'
	public $timestamps = false;

	public function photo(){
		return $this -> hasMany('Photo');
	}

	public function Monitor(){
		return $this -> belongsToMany('Monitor'); //Many to Many relatie
	}

	public function Rating(){
		return $this -> hasMany('Rating');
	}

	public function Registration(){
		return $this -> hasMany('Registration');
	}
}