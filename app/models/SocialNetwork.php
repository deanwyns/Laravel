<?php

class SocialNetwork extends ValidatableEloquent {
	protected $table = 'socialNetworks';
	
	protected $fillable =
		['name', 'link', 'monitor_id'];

	protected $rules = [
		'monitor_id' => 'required',
		'name' => 'required',
		'link' => 'required'
	];

	public function monitor(){
		return $this->belongsTo('Monitor');
	}
	
	public $timestamps = false;
}