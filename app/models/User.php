<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends ValidatableEloquent implements UserInterface, RemindableInterface {

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
	protected $fillable = ['email', 'password'];

	/**
	 * Validation rules for the User model
	 * @var array
	 */
	protected $rules =
		['email' => 'required|email',
		 'password' => 'required|confirmed',
		 'password_confirmed' => 'required'];
}
