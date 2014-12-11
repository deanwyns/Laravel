<?php
use Dingo\Api\Transformer\TransformableInterface;

class Category extends ValidatableEloquent implements TransformableInterface {
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

	public function getTransformer() {
		return new CategoryTransformer;
	}
}