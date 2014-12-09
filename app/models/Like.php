<?php
class Like extends Eloquent {
	protected $table = 'likes';

	public function user() {
		return $this->belongsTo('Parents');
	}

	public function vacation() {
		return $this->belongsTo('Vacation');
	}
}