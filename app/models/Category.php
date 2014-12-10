<?php
class Category extends ValidatableEloquent {
	protected $tables = 'categories';

	protected $fillable = [
		'name',
		'photo_url'
	];

	protected $rules = [
		'name' => 'required|unique:categories,name,{ID}',
		'photo_url' => 'required'
	];

	public function vacations() {
		return $this->belongsToMany('Vacation');
	}
}