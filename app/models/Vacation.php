<?php

class Vacation extends ValidatableEloquent {
	protected $table = 'vacations';

	protected $fillable = [
		'title', 'description', 
		'promoText', // korte beschrijving (voor weergave in lijsten)
		'location', 
		'ageFrom', 'ageTo', // min en max leeftijd om te mogen participeren
		'transportation', 'maxParticipants',
		'baseCost', // Prijs wanneer geen enkele ouder lid is van Bond Moysson 
		'oneBmMemberCost', 'twoBmMemberCost', // idem base_cost maar waar respectievelijk 1 & 2 ouders lid van Bond Moysson
		'taxDeductable',
		'beginDate', 'endDate'
	];

	protected $rules = [
		'title' => 'required|max:140|unique:vacations,title,{ID}',
		'description' => 'required|max: 5000',
		'promoText' => 'required|max: 5000',
		'location' => 'required|max:280',
		'ageFrom' => 'digits_between:1,2',
		'ageTo' => 'digits_between:1,2',
		'transportation' => 'max: 280',
		'maxParticipants' => 'required|numeric|digits_between:1,3',
		// Regex voor decimal met max 2 cijfers na komma. Kun je vervangen door eigen gemaakte validatie regel
		'baseCost' => 'required|regex:/^\€?([1-9]{1}[0-9]{0,2}(\,[0-9]{3})*(\.[0-9]{0,2})?|[1-9]{1}[0-9]{0,}(\.[0-9]{0,2})?|0(\.[0-9]{0,2})?|(\.[0-9]{1,2})?)$/',
		'oneBmMemberCost' => 'required|regex:/^\€?([1-9]{1}[0-9]{0,2}(\,[0-9]{3})*(\.[0-9]{0,2})?|[1-9]{1}[0-9]{0,}(\.[0-9]{0,2})?|0(\.[0-9]{0,2})?|(\.[0-9]{1,2})?)$/',
		'twoBmMemberCost' => 'required|regex:/^\€?([1-9]{1}[0-9]{0,2}(\,[0-9]{3})*(\.[0-9]{0,2})?|[1-9]{1}[0-9]{0,}(\.[0-9]{0,2})?|0(\.[0-9]{0,2})?|(\.[0-9]{1,2})?)$/',
		'taxDeductable' => 'required',
		'beginDate' => 'required',
		'endDate' => 'required'
	];

	public function registrations() {
		return $this->hasMany('Registration');
	}
	
/*
// niet relevant tot de andere tabellen zijn geïmplementeerd
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
	}*/
}