<?php
class Like extends ValidatableEloquent {
	protected $table = 'likes';

	protected $fillable =
	[
		'parents_id',
		'vacation_id'
	];

	protected $rules = 
	[
		'parents_id' => 'required',		
		'vacation_id' => 'required'
	];

	public function user() {
		return $this->belongsTo('Parents');
	}

	public function vacation() {
		return $this->belongsTo('Vacation');
	}
}