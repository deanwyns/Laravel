<?php
use Dingo\Api\Transformer\TransformableInterface;

class Vacation extends ValidatableEloquent implements TransformableInterface {
	protected $table = 'vacations';

	protected $fillable = [
		'title', 'description', 
		'promo_text', // korte beschrijving (voor weergave in lijsten)
		'location', 
		'age_from', 'age_to', // min en max leeftijd om te mogen participeren
		'transportation', 'max_participants',
		'base_cost', // Prijs wanneer geen enkele ouder lid is van Bond Moysson 
		'one_bm_member_cost', 'two_bm_member_cost', // idem base_cost maar waar respectievelijk 1 & 2 ouders lid van Bond Moysson
		'tax_deductable',
		'begin_date', 'end_date',
		'category_id', 'picasa_album_id'
	];

	protected $rules = [
		'title' => 'required|max:140|unique:vacations,title,{ID}',
		'description' => 'required|max: 5000',
		'promo_text' => 'required|max: 5000',
		'location' => 'required|max:280',
		'age_from' => 'digits_between:1,2',
		'age_to' => 'digits_between:1,2',
		'transportation' => 'max: 280',
		'max_participants' => 'required|numeric|digits_between:1,3',
		// Regex voor decimal met max 2 cijfers na komma. Kun je vervangen door eigen gemaakte validatie regel
		'base_cost' => array('required', 'regex:/^([1-9]{1}[0-9]{0,2}(\,[0-9]{3})*(\.[0-9]{0,2})?|[1-9]{1}[0-9]{0,}(\.[0-9]{0,2})?|0(\.[0-9]{0,2})?|(\.[0-9]{1,2})?)$/'),
		'one_bm_member_cost' => array('required', 'regex:/^([1-9]{1}[0-9]{0,2}(\,[0-9]{3})*(\.[0-9]{0,2})?|[1-9]{1}[0-9]{0,}(\.[0-9]{0,2})?|0(\.[0-9]{0,2})?|(\.[0-9]{1,2})?)$/'),
		'two_bm_member_cost' => array('required', 'regex:/^([1-9]{1}[0-9]{0,2}(\,[0-9]{3})*(\.[0-9]{0,2})?|[1-9]{1}[0-9]{0,}(\.[0-9]{0,2})?|0(\.[0-9]{0,2})?|(\.[0-9]{1,2})?)$/'),
		'tax_deductable' => 'required',
		'begin_date' => 'required',
		'end_date' => 'required'
	];

	public function registrations() {
		return $this->hasMany('Registration');
	}

	public function category() {
		return $this->hasOne('Category');
	}

	public function likes() {
		return $this->hasMany('Like');
	}

	public function getTransformer() {
		return new VacationTransformer;
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