<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Dingo\Api\Transformer\TransformableInterface;

class User extends ValidatableEloquent implements UserInterface, RemindableInterface, TransformableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	/**
	 * Fillable attributes
	 * @var array
	 */
	protected $fillable = ['email', 'password', 'userable_id'];

	/**
	 * Validation rules for the User model
	 * @var array
	 */
	protected $rules =
		['email' => 'required|email|unique:users,email,{ID}',
		 'password' => 'required|min:6',
		 'password_confirmed' => 'required_with:password|same:password'];

	public function userable() {
		return $this->morphTo();
	}

	public function scopes() {
		return $this->scopes;
	}

	public function getTransformer() {
		return new UserTransformer;
	}
}