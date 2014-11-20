<?php
class VacationEntry extends Eloquent {
	protected $table = 'vacation_entries';

	public function child() {
		return $this->belongsTo('Child');
	}

	public function vacation() {
		return $this->belongsTo('Vacation');
	}
}