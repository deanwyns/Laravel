<?php
class Like extends ValidatableEloquent {
	protected $table = 'likes';

	public function user() {
		return $this->belongsTo('Parents');
	}

	public function vacation() {
		return $this->belongsTo('Vacation');
	}
}