<?php
use Dingo\Api\Transformer\TransformableInterface;

class Child extends ValidatableEloquent implements TransformableInterface {
	protected $table = 'children';

	protected $fillable = [
		'first_name', 'last_name', 'address_id', 'nrn','date_of_birth', 'parents_id' //nrn = national registry number
	];

	protected $rules = [
		'first_name' => 'required|max:35',
		'last_name' => 'required|max:55',
		'address_id' => 'required',
		'nrn' => 'required| max: 15',
		'parents_id' => 'required',
		'date_of_birth' => 'Required'
	];

	public function registrations() {
		return $this->hasMany('Registration');
	}

	public function parent() {
		return $this->belongsTo('User');
	}

	public function address() {
		return $this->belongsTo('Address');
	}

	public function getTransformer() {
		return new ChildTransformer;
	}

	/*public function address(){
		*/
	public $timestamps = false;
}